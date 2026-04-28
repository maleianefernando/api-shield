<?php

return [
    'secret' => env('AS_SECRET'),
    'noncettl' => env('AS_NONCE_TTL', 300),
    'nonceprefix' => env('AS_NONCE_PREFIX', 'api_shield'),
    'timestamplimit' => env('AS_TIMESTAMP_LIMIT', 120),
];
