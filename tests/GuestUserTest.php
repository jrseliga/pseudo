<?php

use Orchestra\Testbench\TestCase;
use Pseudo\Contracts\GuestContract;
use Illuminate\Support\Facades\Auth;

class GuestUserTest extends TestCase
{
    /**
     * Test that Laravel Auth returns instance of GuestContract.
     */
    public function test_auth_returns_guest()
    {
        $this->assertInstanceOf(GuestContract::class, Auth::user());
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.guards.web.driver', 'pseudo');
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
        return [\Pseudo\Providers\PseudoServiceProvider::class];
    }
}
