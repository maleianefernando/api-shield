<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\SUpport\Str;

class UtilsService
{
    public function writeHmacPattern(string $httpMethod, string $path)
    {
        return Str::upper($httpMethod) . ':' . $path;
    }
}