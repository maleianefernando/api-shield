<?php

namespace Maleianefernando\ApiShield\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UtilitiesService
{
    public static function validateRequestHeaders(Request $request)
    {
        $hasFile = $request->hasFile('file');
        $hasFileHash = $request->hasHeader("X-File-Hash");
        
        if($hasFile) {
            if (! $hasFileHash) {
                return false;
            }
        }

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
        $data = $request->except(['file']);
        ksort($data);
        $body = json_encode($data);

        $method = Str::upper($request->method());
        $uri = $request->getRequestUri();
        $rawBody = $body;
        $timestamp = $request->header("X-Timestamp");
        $nonce = $request->header("X-Nonce");

        $bodyHash = hash('sha256', $method == "GET" ? "" : $rawBody);

        return "{$method}:{$uri}:{$bodyHash}:{$timestamp}:{$nonce}";
    }
}
