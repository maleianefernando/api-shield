<?php
namespace Tests;

use Illuminate\Contracts\Config\Repository; 

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app) 
    {
        return parent::getPackageProviders($app);
    }

    protected function getPackageAliases($app)
    {
        return parent::getPackageAliases($app);
    }

    protected function defineEnvironment($app)
    {
        tap($app['config'], function(Repository $config) {
            $config->set('apishield.secret', 'z@LZdMeyJbcDQxauD-4+qRMWMGa8Aqgx');
            $config->set('apishield.noncettl', 60);
            $config->set('apishield.timestamplimit', 60);

            $config->set('cache.default', 'redis'); // Tested: 'file' | 'redis'

            // $config->set('database.connections.testbench', [ 
            //     'driver'   => 'mysql', 
            //     'database' => 'testbench',
            //     'prefix'   => '', 
            // ]);
        });
        // return parent::defineEnvironment($app);
    }

    protected function setUp(): void
    {
        // Code before application created.

        $this->afterApplicationCreated(function () {
            // Code after application created.
        });

        $this->beforeApplicationDestroyed(function () {
            // Code before application destroyed.
        });

        parent::setUp();
    }

    protected function defineRoutes($router)
    {
        return parent::defineRoutes($router);
    }
}
