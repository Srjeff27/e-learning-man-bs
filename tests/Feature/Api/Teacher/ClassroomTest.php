<?php

namespace Tests\Feature\Api\Teacher;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'guru',
            'is_active' => true,
        ]);

        $this->teacher = new Teacher();
        $this->teacher->user_id = $this->user->id;
        $this->teacher->nip = '123456';
        $this->teacher->full_name = 'Guru Test';
        $this->teacher->save();

        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    public function test_teacher_can_list_classrooms()
    {
        Classroom::create([
            'teacher_id' => $this->user->id,
            'name' => 'Math 101',
            'code' => 'MATH01',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/teacher/classrooms');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'code', 'students_count']
            ]);
    }

    public function test_teacher_can_create_classroom()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/teacher/classrooms', [
                'name' => 'Physics 101',
                'description' => 'Intro to Physics',
                'subject' => 'Physics',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('classroom.name', 'Physics 101');

        $this->assertDatabaseHas('classrooms', ['name' => 'Physics 101']);
    }

    public function test_teacher_can_view_classroom()
    {
        $classroom = Classroom::create([
            'teacher_id' => $this->user->id,
            'name' => 'Biology 101',
            'code' => 'BIO001',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson("/api/teacher/classrooms/{$classroom->id}");

        $response->assertStatus(200)
            ->assertJsonPath('classroom.id', $classroom->id);
    }
}
