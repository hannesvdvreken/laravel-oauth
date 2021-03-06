<?php
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace hannesvdvreken\OAuth;

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
        // assign injected dependencies
        $this->factory = $factory;

        // you can choose the http client through configuration
        if (Config::has('oauth.client'))
        {
            $httpClient = App::make('\OAuth\Common\Http\Client\\' . Config::get('oauth.client'));

            // hey factory, use this HTTP client
            $this->factory->setHttpClient($httpClient);
        }
    }

    /**
     * @param  string $service
     * @param  string $url
     * @param  array  $scope
     * @return \OAuth\Common\Service\AbstractService
     */
    public function consumer($service, $url = null, $scope = null)
    {
        // create credentials object
        $credentials = App::make('\\OAuth\\Common\\Consumer\\Credentials', array(
            'consumerId'     => Config::get("oauth.consumers.$service.client_id"),
            'consumerSecret' => Config::get("oauth.consumers.$service.client_secret"),
            'callbackUrl'    => $url ?: URL::current()
        ));

        // create storage object
        $storage = App::make('\\hannesvdvreken\\OAuth\\Storage\\LaravelSession');

        // use scope from config if not provided
        if (is_null($scope))
        {
            $scope = Config::get("oauth.consumers.$service.scope", array());
        }

        // return the service consumer object
        return $this->factory->createService($service, $credentials, $storage, $scope);
    }
}
