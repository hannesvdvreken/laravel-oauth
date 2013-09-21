<?php namespace hannesvdvreken\OAuth;

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

use \OAuth\ServiceFactory;

use \Config;
use \URL;
use \App;

class OAuth 
{
    private $factory;

    /**
     * Constructor - creates a new instance
     *
     * @param \OAuth\ServiceFactory $factory
     */
    public function __construct(ServiceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param  string $service
     * @return \OAuth\Common\Service\AbstractService
     */
    public function consumer($service, $url = null) 
    {
        // get storage
        $storage_name = Config::get('oauth.storage', 'Session'); // use session as default

        $cn = "\\OAuth\Common\\Storage\\$storage_name";
        if ($storage_name == 'Redis')
        {
            $redis = Redis::connection();
            $storage = new $cn($redis);
        }
        else
        {
            $storage = App::make($cn);
        }

        // create credentials object
        // the only "new"-keyword in this repository.
        $credentials = App::make('\\OAuth\\Common\\Consumer\\Credentials', array(
            'consumerId'     => Config::get("oauth.consumers.$service.client_id"),
            'consumerSecret' => Config::get("oauth.consumers.$service.client_secret"),
            'callbackUrl' => $url ?: URL::current()
        ));

        // get scope (default to empty array)
        $scope = Config::get("oauth.consumers.$service.scope", array());

        // return the service consumer object
        return $this->factory->createService($service, $credentials, $storage, $scope);
    }
}
