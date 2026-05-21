<?php

return [
    'secret' => env('AS_SECRET'),
    'nonce_ttl' => env('AS_NONCE_TTL', 300),
    'nonce_prefix' => env('AS_NONCE_PREFIX', 'api_shield'),
    'timestamp_limit' => env('AS_TIMESTAMP_LIMIT', 120),
    'middleware_alias' => 'api-shield',

    'switch' => [
        
        'enable_rate_limit' => true,
        
        'enable_auditing' => true
    ],

    'rate_limit' => [

        'soft' => env('AS_SOFT_RATE_LIMIT', 60),

        'hard' => env('AS_HARD_RATE_LIMIT', 120),

        'decay_seconds' => env('AS_DECAY_RATE_SECONDS', 60),

        'block_period' => env('AS_REQUEST_BLOCK_PERIOD', 900),
    ],
];
