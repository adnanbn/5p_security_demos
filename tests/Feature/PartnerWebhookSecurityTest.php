<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PartnerWebhookSecurityTest extends TestCase
{
    private const SECRET = 'synthetic-test-only-webhook-secret';

    protected function setUp(): void
    {
        parent::setUp();

        CarbonImmutable::setTestNow('2026-08-08T12:00:00Z');
        Cache::flush();
        config([
            'security.partner_webhook_secret' => self::SECRET,
            'security.partner_webhook_tolerance_seconds' => 300,
        ]);
    }

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow();

        parent::tearDown();
    }

    public function test_a_valid_event_is_accepted_only_once(): void
    {
        $timestamp = (string) now()->getTimestamp();
        $body = $this->payload('booking.updated');

        $this->sendWebhook('evt_001', $timestamp, $body)
            ->assertAccepted()
            ->assertJsonPath('event_id', 'evt_001');

        $this->sendWebhook('evt_001', $timestamp, $body)
            ->assertConflict();
    }

    public function test_a_tampered_body_is_rejected(): void
    {
        $timestamp = (string) now()->getTimestamp();
        $signedBody = $this->payload('booking.updated');
        $tamperedBody = $this->payload('booking.cancelled');

        $this->sendWebhook('evt_002', $timestamp, $tamperedBody, $signedBody)
            ->assertUnauthorized();
    }

    public function test_a_correctly_signed_stale_event_is_rejected(): void
    {
        $timestamp = (string) now()->subMinutes(10)->getTimestamp();
        $body = $this->payload('booking.updated');

        $this->sendWebhook('evt_003', $timestamp, $body)
            ->assertUnauthorized();
    }

    private function payload(string $type): string
    {
        return json_encode([
            'type' => $type,
            'data' => ['booking_id' => 8412],
        ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    }

    private function sendWebhook(
        string $eventId,
        string $timestamp,
        string $body,
        ?string $signedBody = null,
    ): TestResponse {
        $signature = hash_hmac(
            'sha256',
            $timestamp.'.'.($signedBody ?? $body),
            self::SECRET,
        );

        return $this->call(
            'POST',
            '/api/partner/webhooks/bookings',
            server: [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_X_WEBHOOK_ID' => $eventId,
                'HTTP_X_WEBHOOK_TIMESTAMP' => $timestamp,
                'HTTP_X_WEBHOOK_SIGNATURE' => $signature,
            ],
            content: $body,
        );
    }
}
