<?php

/**
 * Interface for a twitter service
 * 
 * @author Damian Mooyman
 * 
 * @package twitter
 */
interface ITwitterService {
	
	/**
	 * Retrieves a list of tweets, each given as an associative array with the
	 * keys 'Date', 'User' and 'Content'
	 * @return array
	 * @param string $count Number of tweets to return 
	 */
	function getTweets($user, $count);
}
