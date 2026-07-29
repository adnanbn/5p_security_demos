<?php

namespace App\Http\Controllers;

use App\Security\PartnerWebhookVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        PartnerWebhookVerifier $verifier,
    ): JsonResponse {
        $eventId = $verifier->verify($request);

        return response()->json([
            'accepted' => true,
            'event_id' => $eventId,
        ], 202);
    }
}
