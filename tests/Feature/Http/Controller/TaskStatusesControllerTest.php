<?php

namespace Tests\Feature\Http\Controller;

use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class TaskStatusesControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(200);
    }

    public function testEdit()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);
        $data = $this->taskStatus->only(['name']);
        $response = $this
            ->patch(route('task_statuses.update', $this->taskStatus), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy()
    {
        $this->actingAs($this->user);
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertRedirect();
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }

    public function testStore()
    {
        $this->actingAs($this->user);
        $response = $this->post(route('task_statuses.store'), $this->taskStatus->toArray());
        $this->assertDatabaseHas('task_statuses', $this->taskStatus->toArray());
        $response->assertRedirect();
    }

    public function testGuestCanNotStore()
    {
        $hadBeen = TaskStatus::count();
        $response = $this->post(route('task_statuses.store'), $this->taskStatus->toArray());
        $became = TaskStatus::count();

        $this->assertEquals($hadBeen, $became);
    }

    public function testGuestCanNotUpdate()
    {
        $oldValue = $this->taskStatus->name;
        $updatedValue = implode(' ', ["Updated Title", rand()]);
        $this->taskStatus->name = $updatedValue;
        $this->patch(route('task_statuses.update', $this->taskStatus), $this->taskStatus->toArray());
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id , 'name' => $oldValue]);
    }

    public function testGuestCanNotDelete()
    {
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
        $this->delete(route('task_statuses.destroy', $this->taskStatus));
        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
