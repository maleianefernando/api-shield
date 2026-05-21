<?php

namespace Maleianefernando\ApiShield\Services;

use Illuminate\Http\Request;
use Maleianefernando\ApiShield\Models\ApiShieldAuditLog;

class AuditService
{
    public static function log(Request $request, string $action, string $result, ?string $reason = null, ?int $statusCode = null, ?int $attempts = null)
    {
        ApiShieldAuditLog::create([
            'request_id' => uniqid('req_', true),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'application_id' => $request->header('X-Client-Id'),
            'application_name' => $request->header('X-Client-Name'),
            'endpoint' => $request->path(),
            'http_method' => $request->method(),
            'status_code' => $statusCode,
            'action' => $action,
            'result' => $result,
            'failure_reason' => $reason,
            'attempts' => $attempts,
        ]);
    }
}
