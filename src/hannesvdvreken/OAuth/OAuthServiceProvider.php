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
		$this->app['oauth'] = $this->app->share(function() { return new OAuth(); });
	}

}