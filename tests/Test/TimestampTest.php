<?php
namespace Tests\Test;

use Maleianefernando\ApiShield\Services\TimestampService;
use Tests\TestCase;

class TimestampTest extends TestCase
{
    public function test_timestamp()
    {
        $t = new TimestampService();
        
        $this->assertTrue($t->isValid(time()));
    }
}
