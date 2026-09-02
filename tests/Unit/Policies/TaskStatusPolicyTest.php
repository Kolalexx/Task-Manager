<?php

namespace Tests\Unit\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use App\Policies\TaskStatusPolicy;
use PHPUnit\Framework\TestCase;

class TaskStatusPolicyTest extends TestCase
{
    private TaskStatusPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new TaskStatusPolicy();
    }

    public function testViewAnyIsAllowedForGuest(): void
    {
        $this->assertTrue($this->policy->viewAny(null));
    }

    public function testCreateIsAllowedForAnyUser(): void
    {
        $this->assertTrue($this->policy->create(new User()));
    }

    public function testUpdateIsAllowedForAnyUser(): void
    {
        $this->assertTrue($this->policy->update(new User(), new TaskStatus()));
    }

    public function testDeleteIsAllowedForAnyUser(): void
    {
        $this->assertTrue($this->policy->delete(new User(), new TaskStatus()));
    }
}
