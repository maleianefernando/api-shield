<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\TimestampService;

/**
 * @author Fernando Maleiane
 * @
 * @method static bool isValid(int $timestamp) Returns true if the timestamp is valid according the config parameters.
 * 
 * @see Maleianefernando\ApiShield\Services\TimestampService.
 */
class Timestamp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TimestampService::class;
    }
}
