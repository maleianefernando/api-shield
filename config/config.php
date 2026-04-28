<?php

return [
    'apishield.secret' => env('AS_SECRET'),
    'noncettl' => env('AS_NONCE_TTL', 300),
    'timestamplimit' => env('AS_TIMESTAMP_LIMIT', 300),
];