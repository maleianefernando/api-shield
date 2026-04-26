<?php

namespace Maleianefernando\ApiShield\Services;

class HmacService
{
    public function write(string $pattern, string $secret): string
    {
        return hash_hmac('sha256', $pattern, $secret);
    }

    public function check(array $hmac): bool
    {
        return hash_equals($hmac[0], $hmac[1]);
    }
}
