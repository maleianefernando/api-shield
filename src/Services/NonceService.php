<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Str;
class NonceService
{
    public function __construct()
    {
    }

    public function persist(string $nonce)
    {
        return Cache::add($nonce, true, 300);
    }

    public function exists(array $nonce)
    {
        return Cache::get($nonce);
    }
}
