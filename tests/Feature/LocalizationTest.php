<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function testProfilePageIsLocalizedInRussian(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('Информация профиля');
        $response->assertSee('Удалить аккаунт');
        $response->assertDontSee('Delete Account');
    }

    public function testDashboardPageIsLocalizedInRussian(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Панель управления');
        $response->assertDontSee('You\'re logged in!');
    }
}
