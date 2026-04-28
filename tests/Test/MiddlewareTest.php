<?php
namespace Tests\Test;

use Maleianefernando\ApiShield\Middleware;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function test_unprotected_function()
    {
        $response = $this->get('/hello-world');

        // dump($response->baseResponse);
        $response->assertStatus(200);
    }

    public function test_protected_function()
    {
        $response = $this->get('/hello-shield', [
            "X-Timestamp" => 1777408414,
            "X-Nonce" => time(), //A dynamic nonce
            "X-Signature" => hash_hmac('sha256', 'Hello world', config('apishield.secret')),
        ]);
        $response->assertStatus(200);
    }
}
