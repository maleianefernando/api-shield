<?php
namespace Tests\Test;

use Illuminate\Support\Str;
use Maleianefernando\ApiShield\Services\NonceService;
use Tests\TestCase;

class NonceTest extends TestCase
{
    public function test_nonce_persistence()
    {
        $uuid = Str::uuid();
        $a = new NonceService();
        // dump($uuid);
        
        $this->assertTrue($a->persist('api_shield:'.'4954eafc-c5d6-48d6-acf0-175581d3dc32'));
    }

    public function test_nonce_retrieving()
    {
        $n = new NonceService();

        $this->assertTrue($n->exists('api_shield:4954eafc-c5d6-48d6-acf0-175581d3dc32'));
    }
}
