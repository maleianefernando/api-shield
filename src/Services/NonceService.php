<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

// use Illuminate\Support\Str;
class NonceService
{
    private $ttl = null, $prefix = null;
    public function __construct()
    {
        $this->ttl = config('apishield.noncettl');
        $this->prefix = config('apishield.nonceprefix');
    }

    public function persist(string $nonce)
    {
        dump($this->getPatternedNonce($nonce));
        throw_if(! Cache::add($this->getPatternedNonce($nonce), true, $this->ttl), \Exception::class, "Please be sure that the given nonce value was never used.");
        
        return true;
    }

    public function exists(string $nonce)
    {
        if(Cache::get($this->getPatternedNonce($nonce))){
            return true;
        }

        return false;
    }

    private function getPatternedNonce ($nonce): string
    {
        return "{$this->prefix}_{$nonce}";
    }
}
