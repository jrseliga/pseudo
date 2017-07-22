# pseudo
Guest user library for Laravel

Branch         |         |         |
------- | ------- | ------- |
master  | [![build status](https://gitlab.com/agilesdesign/pseudo/badges/master/build.svg)](https://gitlab.com/agilesdesign/pseudo/commits/master)   | [![coverage report](https://gitlab.com/agilesdesign/pseudo/badges/master/coverage.svg)](https://gitlab.com/agilesdesign/pseudo/commits/master)
dev     | [![build status](https://gitlab.com/agilesdesign/pseudo/badges/dev/build.svg)](https://gitlab.com/agilesdesign/pseudo/commits/dev)         | [![coverage report](https://gitlab.com/agilesdesign/pseudo/badges/dev/coverage.svg)](https://gitlab.com/agilesdesign/pseudo/commits/dev)

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
Auth::check() // true if User false if Pseudo/Contracts/GuestContract 
```

```php
Auth::user() // returns instance of Pseudo/Contracts/GuestContract instead of null if no user found
```

```php
@can() // no longer automatically fails if not authenticated, allows Gate to be checked
```

## Configuration
#### Update Guard Driver(s)
`config/auth.php`

```php
'guards' => [
    // To use with web guard
    'web' => [
        'driver' => 'pseudo',
        'provider' => 'users',
    ],
    
    // To use with api guard
    'api' => [
        'driver' => 'pseudo-token',
        'provider' => 'users',
    ],
],
```

#### Register Service Provider
> Manually registering the ServiceProvider is only necessary if your Laravel application is version 5.4.* or before.
`config/app.php`

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    \Pseudo\Providers\PseudoServiceProvider::class,
],
```

## Usage
An instance of `Pseudo\Auth\Guest` is resolved from Laravel's Service Container when `Pseudo/Contracts/GuestContract` is requested.

This binding is registered in the supplied ServiceProvider:

```php
public function register()
{
    $this->app->bind(GuestContract::class, Guest::class);
}
```

You may override this by providing your own `GuestUser` class that implements `Pseudo/Contracts/GuestContract` and rebinding the interface:

```php
class GuestUser extends User implements GuestContract
{
    //You can override any attribute by using Eloquent Accessors
    public function getNameAttribute(){
        return 'Guest User';
    }
}
```

```php
this->app->bind(\Pseudo\Contracts\GuestContract::class, \App\GuestUser::class);
```

Policy checks can still be type-hinted for Laravel's `App\User` since `Pseudo\Auth\Guest` extends it.

##### Example
```php
Gate::define('create-article', function ($user, $article) {
    if($user instanceof Pseudo\Auth\Guest)
    {
      // logic for guest
    }
    else
    {
      // logic for authenticated
    }
});
```
