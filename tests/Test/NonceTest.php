<?php
namespace Tests\Test;

use Illuminate\Support\Str;
use Maleianefernando\ApiShield\Facades\Nonce;
use Tests\TestCase;

class NonceTest extends TestCase
{
    public function test_nonce_persistence()
    {
        $uuid = Str::uuid();
        // dump($uuid);
        
        $this->assertTrue(Nonce::persist('4954eafc-c5d6-48d6-acf0-175581d3dc32'));
    }

    public function test_nonce_retrieving()
    {
        // sleep(config('apishield.nonce_ttl'));
        $this->assertTrue(Nonce::exists('4954eafc-c5d6-48d6-acf0-175581d3dc32'));
    }
}
