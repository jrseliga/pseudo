<?php

use Pseudo\Auth\Guest;
use Orchestra\Testbench\TestCase;
use Pseudo\Contracts\GuestContract;
use Pseudo\Providers\PseudoServiceProvider;

class ServiceProviderTest extends TestCase
{
    /**
     * Test that Laravel has an implementation of GuestContract registered.
     */
    public function test_implementation_of_contract_registered_to_container()
    {
        $implementation = app(GuestContract::class);

        $this->assertInstanceOf(GuestContract::class, $implementation);

        $this->assertInstanceOf(Guest::class, $implementation);
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
