<?php

namespace Maleianefernando\ApiShield\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UtilitiesService
{
    public static function validateRequestHeaders(Request $request)
    {
        if(
            $request->hasHeader("X-Timestamp")
            && $request->hasHeader("X-Nonce")
            && $request->hasHeader("X-Signature")
        ){
            return true;
        }

        return false;
    }

    public static function generateStringForHashPattern(Request $request)
    {
        $method = Str::upper($request->method());
        $uri = $request->getRequestUri();
        $rawBody = $request->getContent();
        $timestamp = $request->header("X-Timestamp");
        $nonce = $request->header("X-Nonce");

        $bodyHash = hash('sha256', $method == "GET" ? "" : $rawBody);

        return "{$method}:{$uri}:{$bodyHash}:{$timestamp}:{$nonce}";
    }
}
