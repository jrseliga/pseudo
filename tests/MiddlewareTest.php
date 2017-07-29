<?php

use Illuminate\Http\Request;
use Pseudo\Middleware\Authorize;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Factory as AuthContract;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class MiddlewareTest extends BaseTest
{
    protected $middleware;

    protected $request;

    /**
     * Test that Laravel no longer throws AuthenticationException for can middleware checks.
     */
    public function test_middleware_does_not_require_authentication_but_still_throws_authorization_exception()
    {
        $this->expectException(AuthorizationException::class);

        $this->middleware->handle($this->request, function () {
            return true;
        }, 'not-allowed');
    }

    /**
     * Test that can middleware is handled by the Laravel Gate.
     */
    public function test_middleware_does_not_require_authentication_but_still_authorizes_ability()
    {
        $this->middleware->handle($this->request, function (Request $request) {
            $this->assertTrue(true);
        }, 'allowed');
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->request = new Request();

        $this->setUpGateDefinitions();
        $this->setupAuthorizeMiddleware();
    }

    /**
     * Setup Gate definitions.
     */
    protected function setUpGateDefinitions()
    {
        Gate::define('allowed', function () {
            return true;
        });

        Gate::define('not-allowed', function () {
            return false;
        });
    }

    /**
     * Setup the Authorize middleware.
     */
    protected function setupAuthorizeMiddleware()
    {
        $auth = app(AuthContract::class);
        $gate = app(GateContract::class);

        $this->middleware = new Authorize($auth, $gate);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('auth.guards.web.driver', 'pseudo');
    }
}
