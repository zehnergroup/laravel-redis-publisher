<?php namespace ZehnerGroup\RedisPub;

use Illuminate\Support\ServiceProvider;

use Event;

class RedisPubServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('zehnergroup/redispub');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$this->app['varnish'] = $this->app->share(function($app)
		{
			$varnish = new Varnish;
			$varnish->setChannel($app['config']->get('redispub::channel'));

			return $varnish;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Varnish', 'ZehnerGroup\RedisPub\Facades\Varnish');
		});

		Event::listen('varnish.*', function($domain, $routes)
		{
			$varnish = new Varnish;
			$varnish->setChannel($app['config']->get('redispub::channel'));

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
