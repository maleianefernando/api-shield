<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

// use Illuminate\Support\Str;
class NonceService
{
    private $ttl = null;
    public function __construct()
    {
        $this->ttl = config('apishield.noncettl');
    }

    public function persist(string $nonce)
    {
        throw_if(! Cache::add($nonce, true, $this->ttl), \Exception::class, "Please be sure that the given nonce value was never used.");
        
        return true;
    }

    public function exists(string $nonce)
    {
        if(Cache::get($nonce)){
            return true;
        }

        return false;
    }
}
