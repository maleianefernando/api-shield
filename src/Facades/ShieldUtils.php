<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Utilities\UtilitiesService;

/**
 * @method static bool validateRequestHeaders(\Illuminate\Http\Request $request) Return true for valid request security headers
 * @method static string generateStringForHashPattern(\Illuminate\Http\Request $request, String $fileHash) Return the string pattern ready for Hmac writing, pattern: "HTTP_METHOD:URI:BODYHASH:TIMESTAMP:NONCE"
 * 
 * @see Maleianefernando\ApiShield\Utilities\UtilitiesService
 */

class ShieldUtils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UtilitiesService::class;
    }
}
