<?php

/**
 * Caches a wrapped twitter service
 * 
 * @author Damian Mooyman
 * 
 * @package twitter
 */
class CachedTwitterService implements ITwitterService {
	private static $lifetime = 600; // Lifetime in seconds of cache

	/**
	 * @var ITwitterService
	 */
	protected $cachedService = null;

	function __construct(ITwitterService $service) {
		$this->cachedService = $service;
	}

	function getTweets($user, $count) {
		// Init caching
		$cacheKey = "getTweets_{$user}_{$count}";
		$cache = SS_Cache::factory('CachedTwitterService');
		
		// Return cached value, if available
		if($rawResult = $cache->load($cacheKey)) return unserialize($rawResult);
		
		// Save and return
		$result = $this->cachedService->getTweets($user, $count);
		$cache->save(serialize($result), $cacheKey, array(), self::$lifetime);
		return $result;
	}

}
