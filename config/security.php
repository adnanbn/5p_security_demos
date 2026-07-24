<?php

return [
    'partner_api_key_hash' => env('PARTNER_API_KEY_HASH'),
    'partner_rate_limit_per_minute' => (int) env('PARTNER_RATE_LIMIT_PER_MINUTE', 30),
];
