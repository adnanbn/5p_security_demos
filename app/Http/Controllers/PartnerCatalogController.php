<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerCatalogController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'data' => [
                ['service' => 'security-review', 'available' => true],
                ['service' => 'incident-retro', 'available' => true],
            ],
            'request_id' => $request->attributes->get('request_id'),
        ]);
    }
}
