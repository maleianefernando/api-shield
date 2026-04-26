<?php
namespace Tests;

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
}