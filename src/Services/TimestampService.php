<?php

namespace Maleianefernando\ApiShield\Services;

use DateTime;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Str;
class TimestampService
{
    private $limit = null;
    
    public function __construct()
    {
        $this->limit = config('apishield.timestamp_limit');
    }
        
    public function isValid(int $timestamp): bool
    {
        throw_if(!is_numeric($timestamp), \Exception::class, "Please be sure that this is a valid timestamp.");
        
        throw_if(!DateTime::createFromFormat('U', $timestamp), \Exception::class, "Please be sure that this is a valid timestamp.");

        // sleep(60);
        $diff = abs(time() - $timestamp);

        if($diff > $this->limit) {
            return false;
        }

        return true;
    }
}
