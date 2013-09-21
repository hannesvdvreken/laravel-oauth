<?php namespace hannesvdvreken\OAuth;

use Illuminate\Support\ServiceProvider;
use \App;

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

        // allow for autoresolving a Symfony Session
        $interface = '\\Symfony\\Component\\HttpFoundation\\Session\\SessionInterface';
        $class = '\\Symfony\\Component\\HttpFoundation\\Session\\Session';

        $this->app->bind($interface, $class);
    }
}