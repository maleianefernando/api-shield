<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\TimestampService;

class Timestamp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TimestampService::class;
    }
}
