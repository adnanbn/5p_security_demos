<?php

namespace App\Http\Middleware;

use App\Security\SecurityEventRecorder;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatePartnerApiKey
{
    public function __construct(
        private readonly SecurityEventRecorder $events,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $presented = $request->bearerToken();
        $expectedHash = config('security.partner_api_key_hash');

        if (! is_string($presented) || $presented === '') {
            return $this->deny($request, 'credential_missing');
        }

        if (
            ! is_string($expectedHash)
            || $expectedHash === ''
            || ! hash_equals($expectedHash, hash('sha256', $presented))
        ) {
            return $this->deny($request, 'credential_invalid');
        }

        return $next($request);
    }

    private function deny(Request $request, string $reasonCode): JsonResponse
    {
        Log::warning('partner.request_denied', $request->headers->all());

        $this->events->partnerCredentialDenied($request, $reasonCode);

        return response()->json([
            'message' => 'Invalid partner credential.',
            'request_id' => $request->attributes->get('request_id'),
        ], 401);
    }
}
