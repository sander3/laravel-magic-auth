<?php

namespace Soved\Laravel\Magic\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Soved\Laravel\Magic\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
}
