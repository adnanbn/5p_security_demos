<?php

namespace App\Security;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PartnerWebhookVerifier
{
    public function verify(Request $request): string
    {
        $eventId = trim((string) $request->header('X-Webhook-Id'));
        $timestamp = trim((string) $request->header('X-Webhook-Timestamp'));
        $signature = strtolower(trim((string) $request->header('X-Webhook-Signature')));
        $secret = (string) config('security.partner_webhook_secret');
        $tolerance = max(1, (int) config('security.partner_webhook_tolerance_seconds', 300));

        if (
            $secret === ''
            || preg_match('/\A[A-Za-z0-9._:-]{1,128}\z/', $eventId) !== 1
            || preg_match('/\A[0-9]{10}\z/', $timestamp) !== 1
            || preg_match('/\A[a-f0-9]{64}\z/', $signature) !== 1
        ) {
            abort(401, 'Invalid webhook.');
        }

        if (abs(now()->getTimestamp() - (int) $timestamp) > $tolerance) {
            abort(401, 'Invalid webhook.');
        }

        $expected = hash_hmac(
            'sha256',
            $timestamp.'.'.$request->getContent(),
            $secret,
        );

        if (! hash_equals($expected, $signature)) {
            abort(401, 'Invalid webhook.');
        }

        $replayKey = 'security:webhook:'.hash('sha256', $eventId);

        if (! Cache::add($replayKey, true, now()->addSeconds($tolerance * 2))) {
            abort(409, 'Webhook already processed.');
        }

        return $eventId;
    }
}
