<?php namespace RDI\Publisher;

use Illuminate\Support\ServiceProvider;

class PublisherServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['varnish'] = $this->app->share(function($app)
		{
			return new Varnish;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Varnish', 'RDI\Publisher\Facades\Varnish');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('');
	}

}
