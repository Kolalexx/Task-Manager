<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', $task));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->make();
        $response = $this->post(route('tasks.store'), $task->toArray());
        $this->assertDatabaseHas('tasks', $task
            ->only('name', 'description', 'status_id', 'assigned_to_id'));
        $response->assertRedirect();
    }

    public function testEdit()
    {
        $task = Task::factory()->create();
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('tasks.edit', $task));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $this->actingAs(User::factory()->create());
        $task = Task::factory()->create();
        $data = $task->only(['name', 'description', 'status_id', 'assigned_to_id']);
        $response = $this
            ->patch(route('tasks.update', $task), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy()
    {
        $task = Task::factory()->create();
        $creator = User::find($task->created_by_id);
        $this->actingAs($creator);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect();
        $this->assertSoftDeleted($task);
    }

    public function testGuestCanNotStore()
    {
        $task = Task::factory()->make();
        $hadBeen = Task::count();
        $response = $this->post(route('tasks.store'), $task->toArray());
        $became = Task::count();

        $this->assertEquals($hadBeen, $became);
    }

    public function testGuestCanNotUpdate()
    {
        $task = Task::factory()->create();

        $oldValue = $task->name;
        $updatedValue = implode(' ', ["Updated Title", rand()]);

        $task->name = $updatedValue;
        $this->patch(route('tasks.update', $task), $task->toArray());

        $this->assertDatabaseHas('tasks', ['id' => $task->id , 'name' => $oldValue]);
    }

    public function testGuestCanNotDelete()
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $this->delete(route('tasks.destroy', $task));
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function testNotCreatorCanNotDelete()
    {
        $task = Task::factory()->create();
        $notCreator = User::factory()->create();
        $this->actingAs($notCreator);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
        $this->delete(route('tasks.destroy', $task));
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
