<?php

namespace Tests\Unit;

use App\Security\SecurityEventRecorder;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Mockery;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class SecurityEventRecorderTest extends TestCase
{
    public function test_a_denied_partner_event_does_not_log_credentials_or_headers(): void
    {
        $request = Request::create(
            '/api/partner/catalog',
            'GET',
            server: [
                'HTTP_AUTHORIZATION' => 'Bearer demo-secret-that-must-not-be-logged',
                'REMOTE_ADDR' => '192.0.2.10',
            ],
        );
        $request->attributes->set('request_id', 'request-1234');

        $logger = Mockery::mock(LoggerInterface::class);
        $logger->shouldReceive('warning')
            ->once()
            ->withArgs(function (string $message, array $context): bool {
                $encoded = json_encode($context, JSON_THROW_ON_ERROR);

                return $message === 'security.partner_credential_denied'
                    && ! str_contains($encoded, 'demo-secret')
                    && ! array_key_exists('headers', $context)
                    && $context['request_id'] === 'request-1234';
            });

        $manager = Mockery::mock(LogManager::class);
        $manager->shouldReceive('channel')
            ->once()
            ->with('security')
            ->andReturn($logger);
        $this->app->instance('log', $manager);

        (new SecurityEventRecorder)->partnerCredentialDenied(
            $request,
            'credential_invalid',
        );
    }
}
