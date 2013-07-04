<?php

// Require third party lib
require_once __DIR__ . "/../../thirdparty/twitteroauth/twitteroauth/twitteroauth.php";

/**
 * JSON powered twitter service
 * 
 * @link http://www.webdevdoor.com/javascript-ajax/custom-twitter-feed-integration-jquery/
 * @link http://www.webdevdoor.com/php/authenticating-twitter-feed-timeline-oauth/
 * 
 * @author Damian Mooyman
 * 
 * @package twitter
 */
class TwitterService implements ITwitterService {

	/**
	 * Generate a new TwitterOAuth connection
	 * 
	 * @return TwitterOAuth
	 */
	protected function getConnection() {
		$consumerKey = SiteConfig::current_site_config()->TwitterAppConsumerKey;
		$consumerSecret = SiteConfig::current_site_config()->TwitterAppConsumerSecret;
		$accessToken = SiteConfig::current_site_config()->TwitterAppAccessToken;
		$accessSecret = SiteConfig::current_site_config()->TwitterAppAccessSecret;

		return new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}

	function getTweets($user, $count) {

		// Check user
		if (empty($user)) return null;

		// Call rest api
		$arguments = http_build_query(array(
			'screen_name' => $user,
			'count' => $count,
			'include_rts' => true
		));
		$connection = $this->getConnection();
		$response = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?$arguments");

		// Parse all tweets
		$tweets = array();
		if ($response) foreach ($response as $tweet) {
			$tweets[] = $this->parseTweet($tweet);
		}
		
		return $tweets;
	}

	/**
	 * Converts a tweet response into a simple associative array of fields
	 * 
	 * @param stdObject $tweet Tweet object
	 * @return array Array of fields with Date, User, and Content as keys
	 */
	function parseTweet($tweet) {

		return array(
			'Date' => $tweet->created_at,
			'User' => $tweet->user->screen_name,
			'Content' => $this->parseText($tweet)
		);
	}

	/**
	 * Inject a hyperlink into the body of a tweet
	 * 
	 * @param array $tokens List of characters/words that make up the tweet body,
	 * with each index representing the visible character position of the body text
	 * (excluding markup).
	 * @param stdObject $entity The link object 
	 * @param string $link 'href' tag for the link
	 * @param string $title 'title' tag for the link
	 */
	protected function injectLink(&$tokens, $entity, $link, $title) {
		$startPos = $entity->indices[0];
		$endPos = $entity->indices[1];

		// Inject <a tag at the start
		$tokens[$startPos] = sprintf(
			"<a href='%s' title='%s' target='_blank'>%s",
			Convert::raw2att($link),
			Convert::raw2att($title),
			$tokens[$startPos]
		);
		$tokens[$endPos - 1] = sprintf("%s</a>", $tokens[$endPos - 1]);
	}

	/**
	 * Parse the tweet object into a HTML block
	 * 
	 * @param stdObject $tweet Tweet object
	 * @return string HTML text
	 */
	protected function parseText($tweet) {
		$rawText = $tweet->text;

		// tokenise into characters for parsing
		$tokens = str_split($rawText);

		// Inject links
		foreach ($tweet->entities->urls as $url) {
			$this->injectLink($tokens, $url, $url->url, $url->expanded_url);
		}

		// Inject hashtags
		foreach ($tweet->entities->hashtags as $hashtag) {
			$link = 'https://twitter.com/search?src=hash&q=' . Convert::raw2url('#' . $hashtag->text);
			$text = "#" . $hashtag->text;

			$this->injectLink($tokens, $hashtag, $link, $text);
		}

		// Inject mentions
		foreach ($tweet->entities->user_mentions as $mention) {
			$link = 'https://twitter.com/' . Convert::raw2url($mention->screen_name);
			$this->injectLink($tokens, $mention, $link, $mention->name);
		}

		// Re-combine tokens
		return implode('', $tokens);
	}

}
