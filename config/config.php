<?php

return [
    'secret' => env('AS_SECRET'),
    'nonce_ttl' => env('AS_NONCE_TTL', 300),
    'nonce_prefix' => env('AS_NONCE_PREFIX', 'api_shield'),
    'timestamp_limit' => env('AS_TIMESTAMP_LIMIT', 120),
    'middleware_alias' => 'api-shield',
];
