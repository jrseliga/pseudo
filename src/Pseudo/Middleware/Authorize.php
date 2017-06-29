<?php

namespace Pseudo\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authorize as LaravelAuthorize;

class Authorize extends LaravelAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $this->gate->authorize($ability, $this->getGateArguments($request, $models));

        return $next($request);
    }
}
