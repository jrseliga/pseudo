<?php

namespace Pseudo\Auth;

use App\User;
use Pseudo\Contracts\GuestContract;

class Guest extends User implements GuestContract {}
