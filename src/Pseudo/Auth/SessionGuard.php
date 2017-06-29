<?php

namespace Pseudo\Auth;

use Illuminate\Auth\SessionGuard as LaravelSessionGuard;

class SessionGuard extends LaravelSessionGuard
{
    use GuardHelpers;
}
