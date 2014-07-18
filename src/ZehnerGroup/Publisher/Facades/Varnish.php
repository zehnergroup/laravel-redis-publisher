<?php

namespace ZehnerGroup\RedisPub\Facades;

use Illuminate\Support\Facades\Facade;

class Varnish extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'varnish';
	}
}
