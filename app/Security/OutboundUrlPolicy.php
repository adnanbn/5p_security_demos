<?php

namespace App\Security;

use InvalidArgumentException;
use RuntimeException;

class OutboundUrlPolicy
{
    public function previewUrl(string $relativePath): string
    {
        $baseUrl = rtrim((string) config('security.preview_base_url'), '/');
        $base = parse_url($baseUrl);

        if (
            $base === false
            || ($base['scheme'] ?? null) !== 'https'
            || ! isset($base['host'])
            || isset($base['user'])
            || isset($base['pass'])
            || isset($base['query'])
            || isset($base['fragment'])
        ) {
            throw new RuntimeException('The preview service destination is not configured safely.');
        }

        $decodedPath = rawurldecode($relativePath);

        if (
            $decodedPath !== $relativePath
            || preg_match('#\A/bookings/[1-9][0-9]*\z#D', $relativePath) !== 1
        ) {
            throw new InvalidArgumentException('Use an allowed booking preview path.');
        }

        return $baseUrl.$relativePath;
    }
}
