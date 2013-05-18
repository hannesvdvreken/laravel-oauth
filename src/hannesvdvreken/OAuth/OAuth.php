<?php

/*
|--------------------------------------------------------------------------
| How to use
|--------------------------------------------------------------------------
| eg:
|
| $fb = OAuth::consumer('Facebook'); 
|
| returns a configured consumer object
| class details found here:
|     https://github.com/Lusitanian/PHPoAuthLib/blob/master/src/OAuth/OAuth2/Service/Facebook.php
|
| credentials and scope are loaded from config/oauth.php
|
*/

namespace \hannesvdvreken\OAuth;

use \OAuth\ServiceFactory;
use \OAuth\Common\Consumer\Credentials;

class OAuth {

	/**
	 * @param  string $service
	 * @return \OAuth\Common\Service\AbstractService
	 */
	public static function consumer( $service, $url = null ){

		// create a factory. but remember: this is not java.
		$service_factory = new ServiceFactory();

		// get storage
		$storage_name = Config::get('oauth.Storage');
		$storage_name = $storage_name ?: 'Session'; // default

		$storage = new \OAuth\Common\Storage\$storage_name();

		// create credentials object
		$credentials = new Credentials(
			Config::get("oauth.$service.client_id"),
			Config::get("oauth.$service.client_secret"),
			$url ?: URL::current()
		);

		// get scope (default to empty array)
		$scope = Config::get("oauth.$service.scope") ?: array();

		// return the service consumer object
		return $service_factory->createService($service, $credentials, $storage, $scope);

	}
}