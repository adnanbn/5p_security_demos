<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OutboundRequestSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['security.preview_base_url' => 'https://preview.example.test']);
        Http::preventStrayRequests();
        Http::fake([
            '*' => Http::response(['synthetic' => true], 200),
        ]);
    }

    public function test_preview_requests_use_the_configured_destination(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/previews', [
            'path' => '/bookings/8412',
        ])
            ->assertOk()
            ->assertJsonPath('source', 'configured-preview-service')
            ->assertJsonPath('upstream_status', 200);

        Http::assertSent(fn (Request $request): bool => (
            $request->url() === 'https://preview.example.test/bookings/8412'
            && $request->method() === 'GET'
        ));
        Http::assertSentCount(1);
    }

    public function test_a_caller_cannot_select_an_absolute_destination(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/previews', [
            'path' => '/bookings/8412',
            'url' => 'http://169.254.169.254/latest/meta-data',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['url']);

        Http::assertNothingSent();
    }

    public function test_path_traversal_is_rejected_before_any_request(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/previews', [
            'path' => '/bookings/%2e%2e/internal',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['path']);

        Http::assertNothingSent();
    }

    public function test_an_unapproved_path_on_the_configured_host_is_rejected(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/previews', [
            'path' => '/admin/health',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['path']);

        Http::assertNothingSent();
    }
}
