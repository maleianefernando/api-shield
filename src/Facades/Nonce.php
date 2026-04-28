<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\NonceService;

class Nonce extends Facade
{
    protected static function getFacadeAccessor()
    {
        return NonceService::class;
    }
}
