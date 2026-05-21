<?php
namespace Maleianefernando\ApiShield\Facades;

use Illuminate\Support\Facades\Facade;
use Maleianefernando\ApiShield\Services\AuditService;

/**
 * @method static bool log(\Illuminate\Http\Request $request, string $action, string $result, ?string $reason = null, ?int $statusCode = null, ?int $attempts = null) Logs the information on the database.
 * 
 * @see Maleianefernando\ApiShield\Services\AuditService
 */
class Audit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AuditService::class;
    }
}
