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
        
    public function isValid($timestamp): bool
    {
        try {
            if (!is_numeric($timestamp)) {
                return false;
            }
            $timestamp = (int) $timestamp;
            
            if(!DateTime::createFromFormat('U', $timestamp)) {
                return false;
            }
    
            // sleep(60);
            $diff = time() - $timestamp;
    
            return $diff <= $this->limit;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
