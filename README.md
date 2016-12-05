# pseudo
Guest user library for Laravel

## Description
pseudo adds the ability for guests permissions within Laravel's authentication functionality.

## Installation

##### Include through composer

`composer require agilesdesign/pseudo`

##### Add to provider list

```php
'providers' => [
    Pseudo\Providers\PseudoServiceProvider::class,
];
```

## Overview
Comparison to default Laravel behavior
```php
Auth::check() // true if User false if agilesDesign/Laravel/Pseudo/Contracts/GuestContract 
```

```php
Auth::user() // returns instance of agilesDesign/Laravel/Pseudo/Contracts/GuestContract instead of null if no user found
```

```php
@can() // no longer automatically fails if not authenticated, allows Gate to be checked
```

## Usage
Out of the box this library does not require any additional configuration.

An instance of `agilesdesign\Laravel\Pseudo\Auth\Guest` is resolved from Laravel's Service Container when `agilesDesign/Laravel/Pseudo/Contracts/GuestContract` is requested.

This binding is registered in the supplied ServiceProvider:

```php
public function register()
{
    $this->app->bind(GuestContract::class, Guest::class);
}
```

Policy checks can still be type-hinted for Laravel's `App\User` since `agilesdesign\Laravel\Pseudo\Auth\Guest` extends it.

##### Example
```php
Gate::define('create-article', function ($user, $article) {
    if($user instanceof agilesdesign\Laravel\Pseudo\Auth\Guest)
    {
      // logic for guest
    }
    else
    {
      // logic for authenticated
    }
});
```





