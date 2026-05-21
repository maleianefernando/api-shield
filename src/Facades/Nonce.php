<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\NonceService;

/**
 * @method static bool persist(string $nonce) Return true if the nonce string was successfully saved.
 * @method static bool exists(string $nonce) Return true the $nonce argument was found.
 * @method static get(string $nonce) Return the key and value when the nonce was found or null.
 * 
 * @see Maleianefernando\ApiShield\Services\NonceService
 */
class Nonce extends Facade
{
    protected static function getFacadeAccessor()
    {
        return NonceService::class;
    }
}
