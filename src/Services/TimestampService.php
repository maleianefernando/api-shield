<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Str;
class TimestampService
{
    public function __construct()
    {
    }

    public function isValid(int $timestamp): bool
    {
        if(!is_numeric($timestamp) || (abs(time() - $timestamp) > 300)) {
            return false;
        }

        return true;
    }
}
