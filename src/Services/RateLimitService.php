<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class RateLimitService
{
    private $softLimit = '';
    private $hardLimit = '';
    private $decaySeconds = '';
    private $blockPeriod = '';
    
    public function __construct()
    {
        $this->softLimit = config('apishield.rate_limit.soft');
        $this->hardLimit = config('apishield.rate_limit.hard');
        $this->decaySeconds = config('apishield.rate_limit.decay_seconds');
        $this->blockPeriod = config('apishield.rate_limit.block_period');
    }

    public function handle(string $identifier)
    {
        $key = "api_shield_rate_limit:{$identifier}";
        $blockedKey = "blocked:{$identifier}";

        throw_if(Cache::has($blockedKey), new TooManyRequestsHttpException( $this->blockPeriod, 'Too many requests.' ));
        
        Cache::add($key, 0, $this->decaySeconds);
        
        $count = Cache::increment($key);
        /*
        ** Soft Throttling
        */
        if ($count > $this->softLimit && $count <= $this->hardLimit)
        {
            self::applyProgressiveDelay($count);
        }

        /*
        ** Hard Block
        */
        if ($count > $this->hardLimit)
        {
            Cache::put($blockedKey, true, $this->blockPeriod);
            throw new TooManyRequestsHttpException( $this->blockPeriod, 'Too many requests.' );
        }
    }
    
    protected function applyProgressiveDelay( int $count )
    {
        $excess = $count - $this->softLimit;
        /*
        ** Progressive delay: | 100ms -> 2s
        */
        $delayMs = min( 100 + ($excess * 50), 2000 );
        usleep($delayMs * 1000);
    }
}
