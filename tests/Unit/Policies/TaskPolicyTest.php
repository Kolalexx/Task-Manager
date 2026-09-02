<?php

namespace Tests\Unit\Policies;

use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use PHPUnit\Framework\TestCase;

class TaskPolicyTest extends TestCase
{
    private TaskPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new TaskPolicy();
    }

    public function testViewAnyIsAllowedForGuest(): void
    {
        $this->assertTrue($this->policy->viewAny(null));
    }

    public function testViewIsAllowedForGuest(): void
    {
        $this->assertTrue($this->policy->view(null, new Task()));
    }

    public function testCreateIsAllowedForAnyUser(): void
    {
        $user = new User();

        $this->assertTrue($this->policy->create($user));
    }

    public function testUpdateIsAllowedForAnyUser(): void
    {
        $user = new User();

        $this->assertTrue($this->policy->update($user, new Task()));
    }

    public function testDeleteIsAllowedOnlyForCreator(): void
    {
        $creator = $this->userWithId(1);
        $otherUser = $this->userWithId(2);
        $task = (new Task())->setRelation('creator', $creator);

        $this->assertTrue($this->policy->delete($creator, $task));
        $this->assertFalse($this->policy->delete($otherUser, $task));
    }

    private function userWithId(int $id): User
    {
        $user = new User();
        $user->setAttribute('id', $id);

        return $user;
    }
}
