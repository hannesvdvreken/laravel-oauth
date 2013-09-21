<?php namespace hannesvdvreken\OAuth;

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
        $this->app->bind('oauth', function()
        {
            $this->app->make('OAuth');
        });

        // allow for autoresolving a Symfony Session
        $interface = '\\Symfony\\Component\\HttpFoundation\\Session\\SessionInterface';
        $class = '\\Symfony\\Component\\HttpFoundation\\Session\\Session';

        $this->app->bind($interface, $class);
    }
}