<?php

namespace Pseudo\Providers;

use Pseudo\Auth\Guest;
use Pseudo\Auth\TokenGuard;
use Pseudo\Auth\SessionGuard;
use Pseudo\Middleware\Authorize;
use Pseudo\Contracts\GuestContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PseudoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootRouteMiddleware();

        $this->bootAuthOverrides();
    }

    /**
     * Boot Route Middleware.
     *
     * @return void
     */
    protected function bootRouteMiddleware()
    {
        Route::middleware('can', Authorize::class);
    }

    /**
     * Boot Auth extend overrides.
     */
    protected function bootAuthOverrides()
    {
        $this->bootAuthSessionGuardOverride();

        $this->bootAuthTokenGuardOverride();
    }

    /**
     * Boot Auth extend to override SessionGuard.
     */
    protected function bootAuthSessionGuardOverride()
    {
        Auth::extend('pseudo', function ($app, $name, array $config) {
            $guard = new SessionGuard($name, Auth::createUserProvider($config['provider']), $app['session.store']);

            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;
        });
    }

    /**
     * Boot Auth extend to override TokenGuard.
     */
    protected function bootAuthTokenGuardOverride()
    {
        Auth::extend('pseudo-token', function ($app, $name, array $config) {
            $guard = new TokenGuard(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GuestContract::class, Guest::class);
    }
}
