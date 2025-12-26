<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_get_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => 'guru',
            'is_active' => true,
        ]);

        // Create associated teacher profile
        $teacher = new Teacher();
        $teacher->user_id = $user->id;
        $teacher->nip = '1234567890';
        $teacher->full_name = 'Test Guru';
        $teacher->save();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test-device',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user',
                'role',
            ]);

        $this->assertNotNull($response->json('token'));
    }

    public function test_user_can_access_me_endpoint()
    {
        $user = User::factory()->create([
            'role' => 'siswa',
            'is_active' => true,
        ]);

        $student = new Student();
        $student->user_id = $user->id;
        $student->full_name = 'Test Siswa';
        $student->save();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJson([
                'email' => $user->email,
                'role' => 'siswa',
            ]);

        // Check if relation is loaded (student)
        $this->assertTrue(isset($response->json()['student']));
    }
}
