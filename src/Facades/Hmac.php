<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\HmacService;

/**
 * @method static string write (String $data) Return the hmac string.
 * @method static bool check(array $hmac) Return true the hmac[0] and hmac[1] match.
 * 
 * @see Maleianefernando\ApiShield\Services\HmacService
 */
class Hmac extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HmacService::class;
    }
}
