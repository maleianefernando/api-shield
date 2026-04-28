<?php
namespace Tests\Test;

use Maleianefernando\ApiShield\Services\HmacService;
use Tests\TestCase;

class HmacTest extends TestCase
{
    public function test_hmac()
    {
        // $this->artisan('vendor:publish', [
        //     '--tag' => 'apishield'
        // ]);

        $h = new HmacService();
        $hash = $h->write('Hello world');

        $this->assertTrue($h->check([$hash, hash_hmac('sha256', 'Hello world', config('apishield.secret'))]));
    }
}
