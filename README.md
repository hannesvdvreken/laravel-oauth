# OAuth wrapper for Laravel 4
[![Build Status](https://travis-ci.org/hannesvdvreken/laravel-oauth.png?branch=master)](https://travis-ci.org/hannesvdvreken/laravel-oauth)

**Suggestion:** This is just a Service Provider with a Laravel Session class for token storage. If you would like to keep using Lusitanian's PHPoAuthLib, please use [`artdarek/oauth-4-laravel`](https://github.com/artdarek/oauth-4-laravel) by [Dariusz Prząda](https://github.com/artdarek). If you are interested in [Guzzle](http://guzzle.readthedocs.org/en/latest/)-based service classes, [**look here!**](https://github.com/hannesvdvreken/php-oauth)

## Usage

Follow the steps below and you will be able to get an object of the [service](https://github.com/Lusitanian/PHPoAuthLib/tree/master/src/OAuth/OAuth2/Service) class with one rule:

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

and register this service provider at the bottom of the `providers` array:

```php
'providers' => array(
    ...
    'hannesvdvreken\OAuth\OAuthServiceProvider',
),
```

### Credentials

Add your credentials to app/config/oauth.php

```php
return array(

	/**
	 * One of 'StreamClient' or 'CurlClient'. Defaults to 'StreamClient' if not provided.
	 */
	'client' => 'StreamClient',

    'consumers' => array(
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope' => array(),
        ),
    ),
);
```

## License
[MIT](license)
