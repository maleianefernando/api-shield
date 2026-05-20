<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\RateLimitService;

class RateLimit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RateLimitService::class;
    }
}
