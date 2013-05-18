# OAuth wrapper for Laravel 4

## Usage

Just follow the steps below and you will be able to get a service class object with this one rule:

> $fb = OAuth::provider('Facebook');

## How to integrate

### Alias

Add an alias to the bottom of config/app.php

"OAuth" => "\hannesvdvreken\OAuth\OAuth",

### Credentials

Add your credentials to config/oauth.php

```php
return array(

   'Storage' => 'Session',

	'Facebook' => array(
		'client_id'     => '',
		'client_secret' => '',
		'scope' => array(),
	),
);
```

The 'Storage' attribute is optional and defaults to 'Session'. Other [options](https://github.com/Lusitanian/PHPoAuthLib/tree/master/src/OAuth/Common/Storage)
