<?php

namespace Maleianefernando\ApiShield\Services;

class HmacService
{
    private $secret = null;
    public function __construct()
    {
        $this->secret = config('apishield.secret');
    }

    public function write(string $data): string
    {
        throw_if(!isset($this->secret), \Exception::class, "Hmac secret not set.");

        return hash_hmac('sha256', $data, $this->secret);
    }

    public function check(array $hmac): bool
    {
        throw_if(!isset($hmac[0]) && !isset($hmac[1]), \Exception::class, "Invalid hmac check args.");

        return hash_equals($hmac[0], $hmac[1]);
    }
}
