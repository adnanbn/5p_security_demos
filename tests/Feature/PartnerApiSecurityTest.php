<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PartnerApiSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'security.partner_api_key_hash' => hash('sha256', 'demo-partner-key'),
            'security.partner_rate_limit_per_minute' => 3,
        ]);
    }

    public function test_the_partner_endpoint_requires_a_credential(): void
    {
        $this->getJson('/api/partner/catalog')
            ->assertUnauthorized()
            ->assertJsonMissingPath('token')
            ->assertJsonStructure(['message', 'request_id']);
    }

    public function test_the_partner_endpoint_accepts_the_expected_credential(): void
    {
        $this->withToken('demo-partner-key')
            ->withHeader('X-Request-ID', 'lecture-request-001')
            ->getJson('/api/partner/catalog')
            ->assertOk()
            ->assertHeader('X-Request-ID', 'lecture-request-001')
            ->assertJsonPath('request_id', 'lecture-request-001');
    }

    public function test_the_partner_endpoint_is_rate_limited_before_capacity_is_exhausted(): void
    {
        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->withToken('demo-partner-key')
                ->getJson('/api/partner/catalog')
                ->assertOk();
        }

        $this->withToken('demo-partner-key')
            ->getJson('/api/partner/catalog')
            ->assertTooManyRequests();
    }

    public function test_an_unknown_api_path_does_not_touch_the_database(): void
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $this->getJson('/api/.env')->assertNotFound();

        $this->assertSame([], DB::getQueryLog());
    }
}
