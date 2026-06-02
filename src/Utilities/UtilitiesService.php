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

    public static function generateStringForHashPattern(Request $request, $fileHash = null)
    {
        $data = $request->except(['file']);
        ksort($data);
        $body = json_encode($data);

        $method = Str::upper($request->method());
        $uri = $request->getRequestUri();
        $rawBody = $body;
        $timestamp = $request->header("X-Timestamp");
        $nonce = $request->header("X-Nonce");
        $fHash = $fileHash !== null ? $fileHash : "";

        $bodyHash = hash('sha256', $method == "GET" ? "" : $rawBody);
        $clientCredentials = self::clientCredentials($request);
// return ['server rawbody' => $rawBody,'server pattern' => "{$method}:{$uri}:{$bodyHash}:{$timestamp}:{$nonce}"];
        return $clientCredentials === null 
        ? "{$method}:{$uri}:{$bodyHash}:{$timestamp}:{$nonce}:{$fHash}" 
        : "{$method}:{$uri}:{$bodyHash}:{$timestamp}:{$nonce}:{$fHash}:{$clientCredentials}";
    }

    private static function clientCredentials(Request $request)
    {
        $id = $request->header("X-Client-Id");
        $name = $request->header("X-Client-Name");
        $hasId = false;
        $hasName = false;

        if(isset($id) && trim($id) !== "")
            $hasId = true;

        if(isset($name) && trim($name) !== "")
            $hasName = true;

        if($hasId && $hasName)
            return "{$id}:{$name}";
        else if($hasId)
            return "{$id}";
        else if($hasName)
            return "{$name}";
        else
            return null;
    }
}
