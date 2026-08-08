<?php

namespace App\Http\Controllers;

use App\Security\OutboundUrlPolicy;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class PreviewController extends Controller
{
    public function __invoke(
        Request $request,
        OutboundUrlPolicy $urls,
        HttpFactory $http,
    ): JsonResponse {
        $validated = $request->validate([
            'path' => ['required', 'string', 'max:512'],
            'url' => ['sometimes', 'url'],
        ]);

        try {
            $url = $validated['url'] ?? $urls->previewUrl($validated['path']);
        } catch (InvalidArgumentException $exception) {
            throw ValidationException::withMessages([
                'path' => $exception->getMessage(),
            ]);
        }

        $upstream = $http
            ->acceptJson()
            ->connectTimeout(1)
            ->timeout(2)
            ->withoutRedirecting()
            ->get($url);

        return response()->json([
            'source' => 'configured-preview-service',
            'upstream_status' => $upstream->status(),
        ]);
    }
}
