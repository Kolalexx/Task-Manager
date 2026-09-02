<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskControllerFilterTest extends TestCase
{
    private TaskStatus $firstStatus;
    private TaskStatus $secondStatus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->firstStatus = TaskStatus::factory()->create(['name' => 'Статус первый']);
        $this->secondStatus = TaskStatus::factory()->create(['name' => 'Статус второй']);
    }

    public function testIndexWithEmptyFiltersReturnsAllTasks(): void
    {
        $firstTask = Task::factory()->create([
            'name' => 'Задача A',
            'status_id' => $this->firstStatus->id,
        ]);
        $secondTask = Task::factory()->create([
            'name' => 'Задача B',
            'status_id' => $this->secondStatus->id,
        ]);

        $response = $this->get(route('tasks.index', [
            'filter' => [
                'status_id' => '',
                'created_by_id' => '',
                'assigned_to_id' => '',
            ],
        ]));

        $response->assertOk();
        $response->assertSee($firstTask->name);
        $response->assertSee($secondTask->name);
    }

    public function testIndexAppliesNotEmptyStatusFilter(): void
    {
        $matchingTask = Task::factory()->create([
            'name' => 'Задача под фильтр',
            'status_id' => $this->firstStatus->id,
        ]);
        Task::factory()->create([
            'name' => 'Задача вне фильтра',
            'status_id' => $this->secondStatus->id,
        ]);

        $response = $this->get(route('tasks.index', [
            'filter' => ['status_id' => $this->firstStatus->id],
        ]));

        $response->assertOk();
        $response->assertSee($matchingTask->name);
        $response->assertDontSee('Задача вне фильтра');
    }

    public function testIndexAppliesNotEmptyCreatorFilter(): void
    {
        $creator = User::factory()->create(['name' => 'Создатель уникальный']);
        $matchingTask = Task::factory()->create([
            'name' => 'Задача создателя',
            'created_by_id' => $creator->id,
        ]);
        Task::factory()->create([
            'name' => 'Чужая задача',
            'status_id' => $this->firstStatus->id,
        ]);

        $response = $this->get(route('tasks.index', [
            'filter' => ['created_by_id' => $creator->id],
        ]));

        $response->assertOk();
        $response->assertSee($matchingTask->name);
        $response->assertDontSee('Чужая задача');
    }
}
