<?php

/*
|--------------------------------------------------------------------------
| How to use
|--------------------------------------------------------------------------
| eg:
|
| $fb = OAuth::provider('Facebook'); 
|
| returns a configured service object
| class details found here:
|     https://github.com/Lusitanian/PHPoAuthLib/blob/master/src/OAuth/OAuth2/Service/Facebook.php
|
| credentials and scope are loaded from config/oauth.php
|
*/

namespace \hannesvdvreken\OAuth;

use \OAuth\ServiceFactory;

class OAuth {

	/**
	 * @param  string $service
	 * @return \OAuth\Common\Service\AbstractService
	 */
	public static function provider( $service ){

	}
}