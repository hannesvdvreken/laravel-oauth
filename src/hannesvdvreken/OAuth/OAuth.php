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
        $this->factory = $factory;
    }

    /**
     * @param  string $service
     * @return \OAuth\Common\Service\AbstractService
     */
    public function consumer($service, $url = null) 
    {
        // create credentials object
        // the only "new"-keyword in this repository.
        $credentials = App::make('\\OAuth\\Common\\Consumer\\Credentials', array(
            'consumerId'     => Config::get("oauth.consumers.$service.client_id"),
            'consumerSecret' => Config::get("oauth.consumers.$service.client_secret"),
            'callbackUrl' => $url ?: URL::current()
        ));

        $storage = App::make('\\hannesvdvreken\\OAuth\\Storage\\LaravelSession');

        // get scope (default to empty array)
        $scope = Config::get("oauth.consumers.$service.scope", array());

        // return the service consumer object
        return $this->factory->createService($service, $credentials, $storage, $scope);
    }
}
