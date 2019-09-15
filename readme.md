# Authenticate users using a magic link

Fast and secure passwordless authentication for the masses.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sander3/laravel-magic-auth/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sander3/laravel-magic-auth/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/soved/laravel-magic-auth/v/stable)](https://packagist.org/packages/soved/laravel-magic-auth)
[![Monthly Downloads](https://poser.pugx.org/soved/laravel-magic-auth/d/monthly)](https://packagist.org/packages/soved/laravel-magic-auth)
[![License](https://poser.pugx.org/soved/laravel-magic-auth/license)](https://packagist.org/packages/soved/laravel-magic-auth)

## Requirements

- PHP >= 7.1.3
- Laravel >= 5.6 or 6.0

## Installation

First, install the package via the Composer package manager:

```bash
$ composer require soved/laravel-magic-auth
```

After installing the package, you should publish the configuration file:

```bash
$ php artisan vendor:publish --tag=magic-auth-config
```

Add the `Soved\Laravel\Magic\Auth\Contracts\CanMagicallyLogin` interface to the `App\User` model:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Soved\Laravel\Magic\Auth\Contracts\CanMagicallyLogin as CanMagicallyLoginContract;

class User extends Authenticatable implements CanMagicallyLoginContract
{
    use Notifiable, CanMagicallyLogin;
}

```

Finally, add the `Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin` trait to the `App\User` model to implement the interface.

## Usage

This package exposes two endpoints, one to request a magic link (`magic/email`) and one to authenticate using the magic link (`magic/login`). Your application should make a POST call, containing the user's email address, to request a magic link. The magic link will be send via email using a notification. Feel free to customize the notification by overriding the `CanMagicallyLogin@sendMagicLinkNotification` method.

### Middleware

You may want to register the `Soved\Laravel\Magic\Auth\Http\Middleware\AuthenticateWithMagicLink` middleware to ensure users are authenticated via a magic link.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Sander de Vos via [sander@tutanota.de](mailto:sander@tutanota.de). All security vulnerabilities will be promptly addressed.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
