<?php

namespace Maleianefernando\ApiShield\Services;

class HmacService
{
    public function write(string $data, string $secret): string
    {
        return hash_hmac('sha256', $data, $secret);
    }

    public function check(array $hmac): bool
    {
        return hash_equals($hmac[0], $hmac[1]);
    }
}