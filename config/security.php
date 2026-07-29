<?php

return [
    'partner_api_key_hash' => env('PARTNER_API_KEY_HASH'),
    'partner_rate_limit_per_minute' => (int) env('PARTNER_RATE_LIMIT_PER_MINUTE', 30),
    'partner_webhook_secret' => env('PARTNER_WEBHOOK_SECRET'),
    'partner_webhook_tolerance_seconds' => (int) env('PARTNER_WEBHOOK_TOLERANCE_SECONDS', 300),
    'preview_base_url' => env('PREVIEW_BASE_URL', 'https://preview.example.test'),
    'preview_rate_limit_per_minute' => (int) env('PREVIEW_RATE_LIMIT_PER_MINUTE', 10),
];
