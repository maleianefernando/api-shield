<?php

namespace Maleianefernando\ApiShield\Services;

class HmacService
{
    private $secret = '';
    public function __construct(string $secret)
    {
        $this->setSecret($secret);
    }

    public function setSecret(string $secret)
    {
        $this->secret = $secret;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function write(string $pattern): string
    {
        return hash_hmac('sha256', $pattern, $this->secret);
    }

    public function check(array $hmac): bool
    {
        return hash_equals($hmac[0], $hmac[1]);
    }
}
