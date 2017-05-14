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
Auth::check() // true if User false if Pseudo/Contracts/GuestContract 
```

```php
Auth::user() // returns instance of Pseudo/Contracts/GuestContract instead of null if no user found
```

```php
@can() // no longer automatically fails if not authenticated, allows Gate to be checked
```

## Usage
The only configuration this library requires out of the box is updating the `driver` in your auth guard (config/auth.php) to `pseudo`.

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

    //Here you amy overload anything to be specific to your guest user
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
