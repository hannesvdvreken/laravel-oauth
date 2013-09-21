# OAuth wrapper for Laravel 4
[![Build Status](https://travis-ci.org/hannesvdvreken/laravel-oauth.png?branch=master)](https://travis-ci.org/hannesvdvreken/laravel-oauth)

## Usage

Just follow the steps below and you will be able to get an object of the [service](https://github.com/Lusitanian/PHPoAuthLib/tree/master/src/OAuth/OAuth2/Service) class with one rule:

```php
$fb = OAuth::consumer('Facebook');
$fb = OAuth::consumer('Facebook', 'https://example.com/callback');
```

Optionally, add a second parameter with the URL which the service needs to redirect to. Default, it uses the `URL::current()`, provided by Laravel (L4).

## How to integrate

### Alias

Add an alias to the bottom of app/config/app.php

```php
'OAuth' => 'hannesvdvreken\OAuth\facade\OAuth',
```

and register this service provider at the bottom of the `$providers` array:

```php
'hannesvdvreken\OAuth\OAuthServiceProvider',
```

### Credentials

Add your credentials to app/config/oauth.php

```php
return array(

    'storage' => 'Session',

    'consumers' => array(
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope' => array(),
        ),
    ),
);
```

The `Storage` attribute is optional and defaults to `Session`. Other options: `Memory`, `Redis` or `SymfonySession`. More info [here](https://github.com/Lusitanian/PHPoAuthLib/tree/master/src/OAuth/Common/Storage).

## License
License: MIT

## Like and share
Thanks for your support. Feel free to star this repo and share with friends.