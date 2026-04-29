<?php
declare(strict_types=1);

namespace Maleianefernando\ApiShield\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Maleianefernando\ApiShield\Middleware\ApiShieldMiddleware;
use Maleianefernando\ApiShield\Services\HmacService;
use Maleianefernando\ApiShield\Services\NonceService;
use Maleianefernando\ApiShield\Services\TimestampService;
use Maleianefernando\ApiShield\Utilities\UtilitiesService;

final class ApiShieldServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register your services here
        $this->app->singleton(HmacService::class, function() {
            return new HmacService();
        });
        $this->app->singleton(NonceService::class, function() {
            return new NonceService();
        });
        $this->app->singleton(TimestampService::class, function() {
            return new TimestampService();
        });
        $this->app->singleton(UtilitiesService::class, function() {
            return new UtilitiesService();
        });
        
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'apishield');
        }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Boot your services here
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('apishield.php')
        ], 'apishield');

        $alias = config('apishield.middleware_alias', 'api-shield');
        $router->aliasMiddleware(
            'api-shield',
            ApiShieldMiddleware::class
        );
    }
}
