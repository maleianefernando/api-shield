<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Support\Facades\Cache;

class NonceService
{
    private string $ttl = '', $prefix = '';
    public function __construct()
    {
        $this->ttl = config('apishield.nonce_ttl');
        $this->prefix = config('apishield.nonce_prefix');
    }

    public function persist(string $nonce)
    {
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

    public function get(string $nonce)
    {
        if(Cache::has($this->getPatternedNonce($nonce)))
        {
            return [
                "key" => $this->getPatternedNonce($nonce),
                "value" => Cache::get($this->getPatternedNonce($nonce))
            ];
        }

        return null;
    }

    private function getPatternedNonce (string $nonce): string
    {
        return "{$this->prefix}_{$nonce}";
    }
}
