<?php
declare(strict_types=1);

namespace Maleianefernando\ApiShield\Providers;

use Illuminate\Support\ServiceProvider;
use Maleianefernando\ApiShield\Services\HmacService;

final class ApiShieldServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register your services here
        $this->app->singleton(HmacService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Boot your services here
    }
}
