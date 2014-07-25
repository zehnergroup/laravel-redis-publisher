<?php

namespace ZehnerGroup\RedisPub;

use Redis;

class Varnish {

	private $channel = '';

	public function setChannel($channel)
	{
		$this->channel = $channel;
		return $this;
	}

	public function getChannel()
	{
		return $this->channel;
	}

	public function ban($domain = null, array $routes = array())
	{
		if (is_string($domain) && !empty($domain) && !empty($routes)) {
			$purge_routes = json_encode(array('domain' => $domain, 'routes' => $routes));
			$redis = Redis::connection();
			$redis->publish($this->getChannel(), $purge_routes);
		}
	}
}
