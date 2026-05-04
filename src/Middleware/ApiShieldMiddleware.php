<?php
namespace Maleianefernando\ApiShield\Middleware;

use Illuminate\Http\Request;
use Closure;
use Maleianefernando\ApiShield\Facades\Hmac;
use Maleianefernando\ApiShield\Facades\Nonce;
use Maleianefernando\ApiShield\Facades\ShieldUtils;
use Maleianefernando\ApiShield\Facades\Timestamp;

class ApiShieldMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!ShieldUtils::validateRequestHeaders($request))
        {
            abort(400, "There is security headers missing.");
        }

        $file = $request->file('file');
        if($request->hasFile('file')) {
            $fileHash = hash_file('sha256', $file->getRealPath());

            if(! hash_equals($fileHash, $request->header("X-File-Hash"))) {
                abort(400, "File hash does not match.");
            }
        }

        $timestamp = $request->header("X-Timestamp");
        $nonce = $request->header("X-Nonce");
        $hmac = $request->header("X-Signature");

        
        // dump($request->method());
        // dump($request->getRequestUri());
        // dump($request->header("X-timestamp"));
        // dump($request->header("X-Nonce"));
        // dump($request->getContent());
        // return response(['client-ts' => $timestamp, 'srv-ts'=> time()]);
        if(!Timestamp::isValid($timestamp))
        {
            abort(400, "Invalid request timestamp.");
        }
        
        if(Nonce::exists($nonce))
        {
            dump(Nonce::get($nonce));
            abort(401, "Possible replay attack detected.");
        }

        // $data = $request->except(['file']);
        // ksort($data);
        // $body = json_encode($data);
        // return response(['uri' => $request->getRequestUri()]);
        $pattern = ShieldUtils::generateStringForHashPattern($request);
        $serverHmac = Hmac::write($pattern);
        return (['Hash equals' => hash_equals($serverHmac, $hmac)]);
        
        if(!Hmac::check([$serverHmac, $hmac]))
        {
            abort(400, "Possible manipulation data attack detected.");
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