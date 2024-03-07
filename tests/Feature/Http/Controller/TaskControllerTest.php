<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskControllerTest extends TestCase
{
    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $task = Task::factory()->make();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $this->actingAs($this->user);
        $response = $this->post(route('tasks.store'), $this->task->toArray());
        $this->assertDatabaseHas('tasks', $this->task
            ->only('name', 'description', 'status_id', 'assigned_to_id'));
        $response->assertRedirect();
    }

    public function testEdit()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);
        $data = $this->task->only(['name', 'description', 'status_id', 'assigned_to_id']);
        $response = $this
            ->patch(route('tasks.update', $this->task), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy()
    {
        $creator = User::find($this->task->created_by_id);
        $this->actingAs($creator);
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertRedirect();
        $this->assertSoftDeleted($this->task);
    }

    public function testGuestCanNotStore()
    {
        $hadBeen = Task::count();
        $response = $this->post(route('tasks.store'), $this->task->toArray());
        $became = Task::count();
        $this->assertEquals($hadBeen, $became);
    }

    public function testGuestCanNotUpdate()
    {
        $oldValue = $this->task->name;
        $updatedValue = implode(' ', ["Updated Title", rand()]);
        $this->task->name = $updatedValue;
        $this->patch(route('tasks.update', $this->task), $this->task->toArray());
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id , 'name' => $oldValue]);
    }

    public function testGuestCanNotDelete()
    {
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
        $this->delete(route('tasks.destroy', $this->task));
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
    }

    public function testNotCreatorCanNotDelete()
    {
        $notCreator = $this->user;
        $this->actingAs($notCreator);
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
        $this->delete(route('tasks.destroy', $this->task));
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
    }
}
