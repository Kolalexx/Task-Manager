<?php

namespace Tests\Unit\Policies;

use App\Models\Label;
use App\Models\User;
use App\Policies\LabelPolicy;
use PHPUnit\Framework\TestCase;

class LabelPolicyTest extends TestCase
{
    private LabelPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new LabelPolicy();
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
        $this->assertTrue($this->policy->update(new User(), new Label()));
    }

    public function testDeleteIsAllowedForAnyUser(): void
    {
        $this->assertTrue($this->policy->delete(new User(), new Label()));
    }
}
