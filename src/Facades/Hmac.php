<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\HmacService;

class Hmac extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HmacService::class;
    }
}
