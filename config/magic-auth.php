<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Prefix URI
    |--------------------------------------------------------------------------
    |
    | This URI is used to prefix all magic authentication routes. You may
    | change this value as required, but don't forget to update your forms!
    |
    */

    'uri' => 'magic',

    /*
    |--------------------------------------------------------------------------
    | Expiration Time
    |--------------------------------------------------------------------------
    |
    | The expiration time is the number of minutes that the magic link should
    | be considered valid.
    |
    */

    'expiration' => 5,

    /*
    |--------------------------------------------------------------------------
    | Remembering Users
    |--------------------------------------------------------------------------
    |
    | If you would like to provide "remember me" functionality in your
    | application, you may set this value to true.
    |
    */

    'remember' => false,

];
