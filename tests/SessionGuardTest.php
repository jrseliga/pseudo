<?php

use App\User;

class SessionGuardTest extends GuardBaseTest
{
    protected $guard = 'web';

    protected $driver = 'pseudo';

    /**
     * Test that Laravel Auth knows the authenticated User.
     */
    public function test_user_is_authenticated()
    {
        $this->loadFactories();
        $this->prepareDatabase();

        $user = factory(User::class)->create();

        $this->auth->login($user);

        $this->assertTrue($this->auth->check());
        $this->assertInstanceOf(User::class, $this->auth->authenticate());
    }

    /**
     * Test that Laravel Auth knows if user is not an implementation of GuestContract.
     */
    public function test_can_know_if_user_is_not_guest()
    {
        $this->loadFactories();
        $this->prepareDatabase();

        $user = factory(User::class)->create();

        $this->auth->login($user);

        $this->assertFalse($this->auth->guest());
    }
}
