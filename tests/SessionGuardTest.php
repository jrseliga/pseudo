<?php

use Orchestra\Testbench\TestCase;
use Pseudo\Contracts\GuestContract;
use Illuminate\Support\Facades\Auth;
use Pseudo\Providers\PseudoServiceProvider;

class SessionGuardTest extends TestCase
{
    /**
     * Test that Laravel Auth returns instance of GuestContract.
     */
    public function test_guard_returns_guest()
    {
        $this->assertInstanceOf(GuestContract::class, Auth::guard('web')->user());
    }

    /**
     * Test that Laravel Auth returns can check for guest.
     */
    public function test_guard_determines_if_guest()
    {
        $this->assertTrue(Auth::guard('web')->guest());
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
        return [
            PseudoServiceProvider::class,
        ];
    }
}
