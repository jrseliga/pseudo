<?php

use Pseudo\Contracts\GuestContract;
use Illuminate\Auth\AuthenticationException;

abstract class GuardBaseTest extends BaseTest
{
    /**
     * Test that Laravel Auth returns instance of GuestContract.
     */
    public function test_guard_returns_guest()
    {
        $this->assertInstanceOf(GuestContract::class, $this->auth->user());
    }

    /**
     * Test that Laravel Auth returns can check for guest.
     */
    public function test_guard_determines_if_guest()
    {
        $this->assertTrue($this->auth->guest());
    }

    /**
     * Test that Laravel Auth throws AuthenticationException if user is not authenticated.
     */
    public function test_user_is_not_authenticated()
    {
        $this->expectException(AuthenticationException::class);

        $this->auth->authenticate();
    }

    /**
     * Test that Laravel Auth knows if user is an implementation of GuestContract.
     */
    public function test_can_know_if_user_is_guest()
    {
        $this->assertTrue($this->auth->guest());
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->auth = Auth::guard($this->guard);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.guards.'.$this->guard.'.driver', $this->driver);

        parent::getEnvironmentSetUp($app);
    }
}
