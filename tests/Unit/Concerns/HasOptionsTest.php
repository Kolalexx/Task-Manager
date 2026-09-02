<?php

namespace Tests\Unit\Concerns;

use App\Models\Label;
use App\Models\TaskStatus;
use Illuminate\Support\Collection;
use Tests\TestCase;

class HasOptionsTest extends TestCase
{
    public function testTaskStatusOptionsAreOrderedByNameAndKeyedById(): void
    {
        $third = TaskStatus::factory()->create(['name' => 'Статус В']);
        $first = TaskStatus::factory()->create(['name' => 'Статус А']);
        $second = TaskStatus::factory()->create(['name' => 'Статус Б']);

        $options = TaskStatus::options();

        $this->assertInstanceOf(Collection::class, $options);
        $this->assertSame(
            [$first->id => 'Статус А', $second->id => 'Статус Б', $third->id => 'Статус В'],
            $options->all(),
        );
    }

    public function testLabelOptionsAreOrderedByNameAndKeyedById(): void
    {
        $later = Label::factory()->create(['name' => 'Метка Z']);
        $earlier = Label::factory()->create(['name' => 'Метка A']);

        $options = Label::options();

        $this->assertSame(
            [$earlier->id => 'Метка A', $later->id => 'Метка Z'],
            $options->all(),
        );
    }
}
