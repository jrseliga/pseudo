<?php

use Orchestra\Testbench\TestCase;
use Pseudo\Providers\PseudoServiceProvider;

abstract class BaseTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->getDatabaseEnvironmentSetup($app);
    }

    /**
     * Define database setup.
     *
     * @param $app
     * @return void
     */
    protected function getDatabaseEnvironmentSetup($app)
    {
        $app['config']->set('database.default', 'test');

        $app['config']->set('database.connections.test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PseudoServiceProvider::class,
        ];
    }

    /**
     * Preparate the test database in memory.
     *
     * @return void
     */
    protected function prepareDatabase()
    {
        $this->loadLaravelMigrations(['--database' => 'test']);

        $this->artisan('migrate', ['--database' => 'test']);
    }

    /**
     * Load Factories for use in tests.
     *
     * @return void
     */
    protected function loadFactories()
    {
        $this->loadLaravelFactories();
    }

    /**
     * Load Laravel provided Factories.
     *
     * @return void
     */
    protected function loadLaravelFactories()
    {
        $this->withFactories(__DIR__ . '/../vendor/laravel/laravel/database/factories');
    }
}
