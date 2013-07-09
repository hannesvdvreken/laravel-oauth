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
        $this->app->bind('oauth', function() {

        	return new OAuth();
        	
        });
    }

}