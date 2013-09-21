<?php 
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace hannesvdvreken\OAuth;

use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // bind object for OAuth Facade
        $this->app->bind('oauth', function($app)
        {
            return $app->make('\\hannesvdvreken\\OAuth\\OAuth');
        });

        // bind object for App::make('credentials')
        $this->app->bind('\\OAuth\\Common\\Consumer\\Credentials', function($app, $parameters)
        {
            return new \OAuth\Common\Consumer\Credentials(
                $parameters['consumerId'],
                $parameters['consumerSecret'],
                $parameters['callbackUrl']
            );
        });
    }
}