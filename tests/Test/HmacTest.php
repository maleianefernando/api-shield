<?php
namespace Tests\Test;

use Maleianefernando\ApiShield\Facades\Hmac;
use Tests\TestCase;

class HmacTest extends TestCase
{
    public function test_hmac()
    {
        // $this->artisan('vendor:publish', [
        //     '--tag' => 'apishield'
        // ]);

        $hash = Hmac::write('Hello world');

        $this->assertTrue(Hmac::check([$hash, hash_hmac('sha256', 'Hello world', config('apishield.secret'))]));
    }
}
