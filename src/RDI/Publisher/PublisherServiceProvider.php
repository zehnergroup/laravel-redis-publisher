<?php namespace RDI\Publisher;

use Illuminate\Support\ServiceProvider;

use Event;

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

		Event::listen('varnish.*', function($domain, $routes)
	  {
			$varnish = new Varnish;

			if (Event::firing() == 'varnish.ban') {
				$varnish->ban($domain, $routes);
			}
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
