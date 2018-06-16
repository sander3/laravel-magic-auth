<?php

use Illuminate\Support\Facades\Route;

Route::get('email', 'LoginController@sendMagicLinkEmail')
    ->name('magic.email')->middleware('throttle:1,5');

Route::get('login', 'LoginController@login')
    ->name('magic.login')->middleware('signed');
