<?php

use PHPUnit\Framework\TestCase;
use Maleianefernando\ApiShield\Services\NonceService;
use PHPUnit\Framework\Attributes\Test;

use function PHPUnit\Framework\assertTrue;

class NonceServiceTest extends TestCase
{
    // Good philosophy: Arranje(instantiate, create vars, etc) - Act (The head/logic of the test) - Assert (Get the final result) 
    // BDD - Behavior Driven Development ("it" convention)
    
    #[Test]
    public function it_persists_a_nonce()
    {
        $nonceService = new NonceService();

        $stored = $nonceService->persist('Hello World');
        $this->assertTrue($stored);
    }

    #[Test]
    public function it_reads_a_nonce()
    {
        assertTrue(true);
    }
}
