<?php

namespace Tests\Feature\Api\Student;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'siswa',
            'is_active' => true,
        ]);

        $this->student = new Student();
        $this->student->user_id = $this->user->id;
        $this->student->full_name = 'Siswa Test';
        $this->student->save();

        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    public function test_student_can_join_classroom()
    {
        // Create a classroom (by a teacher)
        $teacher = User::factory()->create(['role' => 'guru']);
        $classroom = Classroom::create([
            'teacher_id' => $teacher->id,
            'name' => 'History 101',
            'code' => 'HIST01',
            'status' => 'active',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/student/classrooms/join', [
                'code' => 'HIST01',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('classroom.id', $classroom->id);

        $this->assertDatabaseHas('classroom_members', [
            'classroom_id' => $classroom->id,
            'user_id' => $this->user->id,
            'role' => 'student',
        ]);
    }

    public function test_student_can_list_enrolled_classrooms()
    {
        $teacher = User::factory()->create(['role' => 'guru']);
        $classroom = Classroom::create([
            'teacher_id' => $teacher->id,
            'name' => 'Math 101',
            'code' => 'MATH01',
            'status' => 'active',
        ]);

        $classroom->members()->attach($this->user->id, ['role' => 'student']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/student/classrooms');

        $response->assertStatus(200)
            ->assertJsoncount(1);
    }
}
