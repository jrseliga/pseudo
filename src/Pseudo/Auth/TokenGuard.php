<?php

namespace Pseudo\Auth;

use Illuminate\Auth\TokenGuard as LaravelTokenGuard;

class TokenGuard extends LaravelTokenGuard
{
    use GuardHelpers;
}
