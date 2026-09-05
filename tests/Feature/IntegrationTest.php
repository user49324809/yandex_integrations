<?php

namespace Tests\Feature;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_integration_endpoints(): void
    {
        $this->get('/reviews-data')->assertRedirect('/login');
        $this->post('/integration', [])->assertRedirect('/login');
    }

    public function test_user_can_save_yandex_company_url(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/integration', [
                'yandex_url' => 'https://yandex.ru/maps/org/example/123456789/',
            ])
            ->assertSuccessful()
            ->assertJsonPath('company_id', '123456789');

        $this->assertDatabaseHas('integrations', [
            'user_id' => $user->id,
            'company_id' => '123456789',
        ]);
    }

    public function test_url_without_company_id_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/integration', [
                'yandex_url' => 'https://yandex.ru/maps/org/example/',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('yandex_url');
    }

    public function test_reviews_use_current_users_saved_integration(): void
    {
        $user = User::factory()->create();
        Integration::create([
            'user_id' => $user->id,
            'yandex_url' => 'https://yandex.ru/maps/org/example/123456789',
            'company_id' => '123456789',
        ]);

        $this->actingAs($user)
            ->getJson('/reviews-data')
            ->assertSuccessful()
            ->assertJsonStructure([
                'company' => ['rating', 'reviews_count'],
                'reviews' => [['author', 'rating', 'text', 'date']],
            ]);
    }

    public function test_reviews_explain_when_integration_is_missing(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/reviews-data')
            ->assertNotFound()
            ->assertJsonPath('error', 'Сначала сохраните ссылку на компанию в настройках.');
    }
}
