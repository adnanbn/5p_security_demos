<?php

namespace App\Security;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecurityEventRecorder
{
    public function authorization(
        Request $request,
        string $decision,
        string $reasonCode,
        ?int $actorId,
        string $resourceType,
        int|string $resourceId,
    ): void {
        Log::channel('security')->info('security.authorization', [
            'event' => 'authorization_decision',
            'request_id' => $request->attributes->get('request_id'),
            'actor_id' => $actorId,
            'resource_type' => $resourceType,
            'resource_id' => (string) $resourceId,
            'decision' => $decision,
            'reason_code' => $reasonCode,
        ]);
    }

    public function partnerCredentialDenied(Request $request, string $reasonCode): void
    {
        Log::channel('security')->warning('security.partner_credential_denied', [
            'event' => 'credential_denied',
            'request_id' => $request->attributes->get('request_id'),
            'path' => '/'.$request->path(),
            'method' => $request->method(),
            'source_ip' => $request->ip(),
            'reason_code' => $reasonCode,
        ]);
    }
}
