# laravel-licence-client

<div class="filament-hidden">

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)

<!-- [![Total Downloads](https://img.shields.io/packagist/dt/pxlrbt/filament-excel.svg)](https://packagist.org/packages/shumonpal/laravel-app-tracker) -->


</div>

Laravel Licence (for Client) is a powerful Laravel package designed to simplify and secure your app from hacker or stealer


## Installation

Install via Composer. You should use Laravel >= 8, PHP >=8.0

```bash
composer require shumonpal/laravel-licence-client
```

## Quickstart

Just 3 step to implement this

Step 1: Run this command
```bash
php artisan vendor:publish --provider="Shumonpal\ProjectSecurity\ProjectSecurityServiceProvider" --tag="app-licence-config"
```

Step 2: Add your licence key external url in `config/app-licence.php` where your key will be verify(Otherwise you can use our [laravel-app-tracker](https://packagist.org/packages/shumonpal/laravel-app-tracker))

Example:

```php
<?php


return [
    /**
     * The Url where licenced key  
     */
    'licence_key_api' => 'https://example.com/api/app-tracker/licence-key-verify',
    
    /**
     * The Url where user details stored if product use illegally
     */
    'store_user_api' => 'https://example.com/api/app-tracker/licence-users',

    /**
     * 
     * This is used to redirect after successfully licence key verified.
     *
     */
    'redirect_url' => '/',
];
```

Step 3: Add `\Shumonpal\ProjectSecurity\Middleware\LicencedVirifiedMiddleware::class` middleware to `kernel.php`

Example

```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /////

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        
        ///

        'verifylicence' => \Shumonpal\ProjectSecurity\Middleware\LicencedVirifiedMiddleware::class,
    ];
}

```
That's it. Now use `verifylicence` middleware wherever you want.


