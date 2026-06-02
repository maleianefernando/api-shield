<?php
namespace Maleianefernando\ApiShield\Middleware;

use Illuminate\Http\Request;
use Closure;
use Maleianefernando\ApiShield\Facades\Audit;
use Maleianefernando\ApiShield\Facades\Hmac;
use Maleianefernando\ApiShield\Facades\Nonce;
use Maleianefernando\ApiShield\Facades\RateLimit;
use Maleianefernando\ApiShield\Facades\ShieldUtils;
use Maleianefernando\ApiShield\Facades\Timestamp;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ApiShieldMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $audit = [
            'status_code' => null,
            'action' => 'api request',
            'result' => 'success',
            'failure_reason' => null,
            'attempts' => null,
        ];

        try {
            if(config('apishield.switch.enable_rate_limit')) {
                RateLimit::handle($request->ip());
            }

            if(!ShieldUtils::validateRequestHeaders($request))
            {
                response()->json(
                    [
                        "status" => "Error",
                        "message" => "There is security headers missing."
                    ],
                    400
                );
            }
    
            $file = $request->file('file');
            $fileHash = null;
            if($request->hasFile('file')) {
                $fileHash = hash_file('sha256', $file->getRealPath());
    
                if(! hash_equals($fileHash, $request->header("X-File-Hash"))) {
                    response()->json(
                        [
                            "status" => "Error",
                            "message" => "Uploaded file integrity compromised."
                        ],
                        422
                    );
                }
            }
    
            $timestamp = $request->header("X-Timestamp");
            $nonce = $request->header("X-Nonce");
            $hmac = $request->header("X-Signature");

            // return response(["a" => env('AS_TIMESTAMP_LIMIT')]);
            if(!Timestamp::isValid($timestamp))
            {
                // return "a";
                return response()->json(
                    [
                        "status" => "Error",
                        "message" => "Invalid request timestamp."
                    ],
                    408
                );
            }
            
            if(Nonce::exists($nonce))
            {
                return response()->json(
                    [
                        "status" => "Error",
                        "message" => "Possible replay attack detected.",
                    ], 409
                );
            }

            $pattern = ShieldUtils::generateStringForHashPattern($request, $fileHash);
            $serverHmac = Hmac::write($pattern);
            // return (['Hash equals' => hash_equals($serverHmac, $hmac)]);
            if(!Hmac::check([$serverHmac, $hmac]))
            {
                return response()->json(
                    [
                        "status" => "Error",
                        "message" => "Possible data manipulation attack detected.",
                    ], 422
                );
                
            }
            // return response(['hmac match' =>true]);
    
            try
            {
                Nonce::persist($nonce);
                // return response(['nonce' => $nonce]);
            }catch (\Exception $e)
            {
                return response()->json(
                    [
                        "status" => "Error",
                        "message" => $e->getMessage()
                    ], 409
                );
            }

            $response = $next($request);

            $audit['status_code'] = $response->getStatusCode();

            return $response;
        } catch (Throwable $e) {
            $audit['result'] = 'failure';
            $audit['failure_reason'] = $e->getMessage();
            $audit['status_code'] = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            throw $e;
        } finally {
            if(config('apishield.switch.enable_auditing')) {
                Audit::log($request, $audit['action'], $audit['result'], $audit['failure_reason'], $audit['status_code'], $audit['attempts']);
            }
        }

    }
}