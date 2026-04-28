<?php

namespace Maleianefernando\ApiShield\Utilities;

use Illuminate\Http\Request;
use Illuminate\SUpport\Str;

class Utilities
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
}