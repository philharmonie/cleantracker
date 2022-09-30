<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $this->actingAs(\App\Models\User::factory()->create())
            ->post('/tasks', [
                'name' => 'Test Task',
                'points' => 1,
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_user_can_not_create_task_with_mussing_values()
    {
        $this->actingAs(\App\Models\User::factory()->create())
            ->post('/tasks', [])
            ->assertRedirect()
            ->assertSessionHasErrors(['name', 'points']);
    }
}
