<?php
namespace Maleianefernando\ApiShield\Middleware;

use Illuminate\Http\Request;
use Closure;
use Maleianefernando\ApiShield\Facades\Hmac;
use Maleianefernando\ApiShield\Facades\Nonce;
use Maleianefernando\ApiShield\Facades\ShieldUtils;
use Maleianefernando\ApiShield\Facades\Timestamp;

class ApiShield
{
    public function handle(Request $request, Closure $next)
    {
        if(!ShieldUtils::validateRequestHeaders($request))
        {
            abort(400, "There is security headers missing.");
        }

        $timestamp = $request->header("X-Timestamp");
        $nonce = $request->header("X-Nonce");
        $hmac = $request->header("X-Signature");

        
        // dump($request->method());
        // dump($request->getRequestUri());
        // dump($request->header("X-timestamp"));
        // dump($request->header("X-Nonce"));
        // dump($request->getContent());
        
        if(!Timestamp::isValid($timestamp))
        {
            abort(400, "Invalid request timestamp.");
        }
        
        if(Nonce::exists($nonce))
        {
            abort(401, "Possible replay attack detected.");
        }
        
        $pattern = ShieldUtils::generateStringForHashPattern($request);
        dump("Server: ".$pattern);
        $serverHmac = Hmac::write($pattern);
        // dump($pattern);
        
        if(!Hmac::check([$serverHmac, $hmac]))
        {
            abort(400, "Invalid request hash.");
        }

        try
        {
            Nonce::persist($nonce);
        }catch (\Exception $e)
        {
            abort(500, $e->getMessage());
        }

        return $next($request);
    }
}