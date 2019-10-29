<?php

namespace Bpocallaghan\Generators\Tests;

use Bpocallaghan\Generators\GeneratorsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GeneratorsServiceProvider::class
        ];
    }

    /**
     * Resolve application core configuration implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $path = __DIR__ . '/../resources/stubs/';

        $app['config']->set('generators.view_stub', "{$path}view.stub");



        //$app['config']->set('generators.settings.view.path', "../tests/resources/views/");
    }
}
