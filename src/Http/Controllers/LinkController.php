<?php

namespace Soved\Laravel\Magic\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Soved\Laravel\Magic\Auth\SendsMagicLinkEmails;

class LinkController extends Controller
{
    use SendsMagicLinkEmails;
}
