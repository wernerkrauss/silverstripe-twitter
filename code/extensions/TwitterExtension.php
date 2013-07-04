<?php

/**
 * Provides twitter api access for page controllers
 *
 * @author Damian Mooyman
 * 
 * @package twitter
 */
class TwitterExtension extends Extension {

	/**
	 * @var ITwitterService
	 */
	protected $twitterService = null;

	/**
	 * Set the service to use for accessing twitter
	 * @param ITwitterService $twitterService 
	 */
	public function setTwitterService(ITwitterService $twitterService) {
		$this->twitterService = $twitterService;
	}

	/**
	 * Retrieves the latest tweet
	 * 
	 * @return ArrayData
	 */
	public function LatestTweet() {
		return $this->LatestTweets()->first();
	}
	
	/**
	 * Retrieves (up to) the last $count tweets.
	 * 
	 * Note: Actual returned number may be less than 10 due to reasons
	 * 
	 * @param integer $count
	 * @return ArrayList
	 */
	public function LatestTweets($count = 10) {
		$items = new ArrayList();
		
		// Check that the twitter user is configured
		$user = SiteConfig::current_site_config()->TwitterUsername;
		if (empty($user)) return $items;

		$tweets = $this->twitterService->getTweets($user, $count);
		foreach ($tweets as $tweet) {
			$tweet['DateObject'] = DBField::create_field('SS_DateTime', $tweet['Date']);
			$items->push(new ArrayData($tweet));
		}
		return $items;
	}
	
}
