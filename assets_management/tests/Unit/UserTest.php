<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_be_admin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isStudent());
    }

    /** @test */
    public function user_can_be_student()
    {
        $student = User::factory()->create([
            'role' => 'student',
        ]);
        
        $this->assertTrue($student->isStudent());
        $this->assertFalse($student->isAdmin());
    }

    /** @test */
    public function user_role_defaults_to_student()
    {
        $user = User::factory()->create([
            'name' => 'Default Role User',
            'email' => 'default@example.com',
            // Not specifying role
        ]);
        
        $this->assertEquals('student', $user->role);
        $this->assertTrue($user->isStudent());
    }

    /** @test */
    public function user_has_correct_role_options()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        
        $student = User::factory()->create([
            'role' => 'student',
        ]);
        
        $this->assertEquals('admin', $admin->role);
        $this->assertEquals('student', $student->role);
    }
}