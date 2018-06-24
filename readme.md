# Authenticate users using a magic link

## Requirements

- PHP >= 7.1.3
- Laravel >= 5.6

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

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Sander de Vos via [sander@tutanota.de](mailto:sander@tutanota.de). All security vulnerabilities will be promptly addressed.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
