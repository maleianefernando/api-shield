<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Utilities\UtilitiesService;

class ShieldUtils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UtilitiesService::class;
    }
}
