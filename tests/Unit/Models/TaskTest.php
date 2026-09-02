<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function testFormattedDateReturnsDayMonthYear(): void
    {
        $task = new Task();
        $task->created_at = Carbon::parse('2024-01-05 12:34:56');

        $this->assertSame('05.01.2024', $task->formattedDate);
    }

    public function testFormattedDateIsNullWhenCreatedAtIsMissing(): void
    {
        $task = new Task();

        $this->assertNull($task->formattedDate);
    }

    public function testFillableContainsExpectedColumns(): void
    {
        $task = new Task();

        $this->assertSame([
            'name',
            'description',
            'status_id',
            'created_by_id',
            'assigned_to_id',
        ], $task->getFillable());
    }
}
