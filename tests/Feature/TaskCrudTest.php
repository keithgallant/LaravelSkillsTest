<?php

namespace Tests\Feature;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_user_can_create_a_task()
    {
        $postData = [
            'name' => 'Some Task Name',
            'priority' => 0,
            'project_id' => 0
        ];

        $response = $this->post(route('tasks.store'), $postData);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $postData);
    }

    public function test_a_user_can_read_all_tasks()
    {
        $tasks = Task::factory()->count(3)->create();
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
        $response->assertSee($tasks->first()->name);
    }

    public function test_a_user_can_update_a_task()
    {
        $task = Task::factory()->create(['name' => 'Old Name', 'priority' => 0, 'project_id' => 0]);
        $updatedData = [
            'name' => 'New Name'
        ];
        $response = $this->put(route('tasks.update', $task), $updatedData);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $updatedData);
        $this->assertDatabaseMissing('tasks', ['name' => 'Old Name']);
    }

    public function test_a_user_can_delete_a_task()
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertModelMissing($task);
    }
}
