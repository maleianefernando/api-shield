<?php

use PHPUnit\Framework\TestCase;
use Maleianefernando\ApiShield\Services\HmacService;
use PHPUnit\Framework\Attributes\Test;

class HmacServiceTest extends TestCase
{
    // Good philosophy: Arranje(instantiate, create vars, etc) - Act (The head/logic of the test) - Assert (Get the final result) 
    // BDD - Behavior Driven Development ("it" convention)
    
    #[Test]
    public function it_generates_hmac()
    {
        $hmacService = new HmacService(getenv('HMAC_SECRET'));
        $hash = $hmacService->write('Hello World');
        // dump($hash);
        $this->assertNotEmpty($hash);
    }

    #[Test]
    public function it_checks_hmac_integrity()
    {
        $hmacService = new HmacService(getenv('HMAC_SECRET'));
        $hash = $hmacService->write('Hello World');

        $this->assertTrue($hmacService->check([$hash, hash_hmac('sha256', 'Hello World', getenv('HMAC_SECRET'))]));
    }
    
    #[Test]
    public function it_checks_a_hash_generated_on_nodejs ()
    {
        // dump("Secret:". getenv('HMAC_SECRET'));
        $hmacService = new HmacService(getenv('HMAC_SECRET'));
        $phpHash = $hmacService->write('Hello World');

        $nodeJsHash = 'd56770bbcaf2efa08d96cc7cbebd1e5c08972d496ad846d1c345522a671c88cc';

        $this->assertTrue($hmacService->check([$nodeJsHash, $phpHash]));
    }

    #[Test]
    public function it_checks_for_an_invalid_secret()
    {
        $hmacService = new HmacService(getenv('HMAC_SECRET'));
        $hash = $hmacService->write('Hello World');

        $diffHmacService = new HmacService('z@LZdMeyJbcDQxauD-4+qRMWMGa8Aqg');
        $diffHash = $diffHmacService->write('Hello World');

        $this->assertFalse($hmacService->check([$hash, $diffHash]));
    }

}