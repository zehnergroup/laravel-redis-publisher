<?php

namespace ZehnerGroup\Publisher;

use Redis;

class Varnish {

	const CHANNEL = 'varnish:purge';

	public function ban($domain = null, array $routes = array())
	{
		if (is_string($domain) && !empty($domain) && !empty($routes)) {
			$purge_routes = json_encode(array('domain' => $domain, 'routes' => $routes));
			$redis = Redis::connection();
			$redis->publish(self::CHANNEL, $purge_routes);
		}
	}
}
