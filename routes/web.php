<?php

use Illuminate\Support\Facades\Route;

Route::post('email', 'LinkController@sendMagicLinkEmail')
    ->name('magic.email')->middleware('throttle:5,5');

Route::get('login', 'LoginController@login')
    ->name('magic.login')->middleware('throttle:12,60');
