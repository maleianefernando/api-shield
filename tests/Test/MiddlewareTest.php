<?php
namespace Tests\Test;

use Maleianefernando\ApiShield\Facades\ShieldUtils;
use Maleianefernando\ApiShield\Middleware;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function test_unprotected_function()
    {
        $body = "";
        $nonce = time();
        $timestamp = time();
        $stringBody = json_encode($body);
        $bodyHash = hash('sha256',$body);

        $pattern = "GET:/hello-world:{$bodyHash}:{$timestamp}:{$nonce}";
        // dump("Client: ".$pattern);
        
        $this->withoutExceptionHandling();
        try
        {
            $response = $this->getJson('/hello-world',
            [
                "X-Timestamp" => $timestamp,
                "X-Nonce" => $nonce, //A dynamic nonce
                "X-Signature" => hash_hmac('sha256', $pattern, config('apishield.secret')),
            ]);
    
            // dump($response->baseResponse);
            $response->assertStatus(200);
        } catch (\Exception $e)
        {
            dump($e);
        }
    }

    public function test_protected_function()
    {
        $body = [
            "name" => "John Doe",
            "Age" => 35
        ];
        $nonce = time()+1;
        $timestamp = time()+1;
        $stringBody = json_encode($body);
        $bodyHash = hash('sha256',$stringBody);

        $pattern = "POST:/hello-shield:{$bodyHash}:{$timestamp}:{$nonce}";
        // dump("Client: ".$pattern);

        $this->withoutExceptionHandling();
        try{
            $response = $this->postJson('/hello-shield',
            $body,
            [
                "X-Timestamp" => $timestamp,
                "X-Nonce" => $nonce, //A dynamic nonce
                "X-Signature" => hash_hmac('sha256', $pattern, config('apishield.secret')),
            ]);
            $response->assertStatus(200);
        } catch (\Exception $e) {
            dump($e);
        }
    }
}
