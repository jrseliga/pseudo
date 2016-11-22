<?php

namespace Pseudo\Providers;

use Pseudo\Auth\Guest;
use Pseudo\Auth\SessionGuard;
use Pseudo\Contracts\GuestContract;
use Pseudo\Middleware\Authorize;
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

    protected function bootAuthOverrides()
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

    protected function bootRouteMiddleware()
    {
        Route::middleware('can', Authorize::class);
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
