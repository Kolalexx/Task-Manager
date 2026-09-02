<?php

namespace Tests\Feature\Profile;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class DeleteProfileTest extends TestCase
{
    public function testUserWithoutTasksCanDeleteAccount(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('profile.destroy'), ['password' => 'password']);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertGuest();
    }

    public function testUserWithCreatedTasksCannotDeleteAccount(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Task::factory()->create(['created_by_id' => $user->id]);

        $response = $this->delete(route('profile.destroy'), ['password' => 'password']);

        $response->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertAuthenticatedAs($user);
        $response->assertSessionHas('flash_notification');
        $this->assertStringContainsString(
            'аккаунт',
            session('flash_notification')[0]['message'],
        );
    }

    public function testUserOnlyAssignedToTaskCannotDeleteAccount(): void
    {
        $creator = User::factory()->create();
        $assignee = User::factory()->create();
        $this->actingAs($assignee);
        Task::factory()->create([
            'created_by_id' => $creator->id,
            'assigned_to_id' => $assignee->id,
        ]);

        $response = $this->delete(route('profile.destroy'), ['password' => 'password']);

        $response->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('users', ['id' => $assignee->id]);
    }
}
