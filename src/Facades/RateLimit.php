<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\RateLimitService;

/**
 * @method static void handle(string $identifier) Handles the request rate limiting according to the apishield parameters.
 * 
 * @see Maleianefernando\ApiShield\Services\RateLimitService
 */
class RateLimit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RateLimitService::class;
    }
}
