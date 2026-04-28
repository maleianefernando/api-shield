<?php
namespace Tests\Test;

use Tests\TestCase;
use Maleianefernando\ApiShield\Facades\Timestamp;

class TimestampTest extends TestCase
{
    public function test_timestamp()
    {
        $this->assertTrue(Timestamp::isValid(time()));
    }
}
