<?php
if (class_exists('Widget')) {

	/**
	 * Adds sidebar widget for twitter
	 * 
	 * @author Damian Mooyman
	 * 
	 * @package twitter
	 */
	class TwitterWidget extends Widget {

		private static $db = array(
			"Title" => "Varchar(255)",
			'TweetCount' => 'Int'
		);

		private static $defaults = array(
			'Title' => 'Twitter Feed',
			'TweetCount' => 3
		);

		private static $title = 'Twitter Feed';

		private static $cmsTitle = 'Twitter Feed';

		private static $description = 'Shows twitter posts in the sidebar.';

		function getCMSFields() {
			$this->beforeUpdateCMSFields(function(&$fields) {
				$fields->merge(array(
					new TextField('Title', 'Title', null, 255),
					new NumericField('TweetCount', 'Tweet Count')
				));
			});

			return parent::getCMSFields();
		}

		function getLatestTweets() {
			$controller = Controller::curr();
			return $controller->LatestTweets($this->TweetCount);
		}

		function Title() {
			return $this->Title ? $this->Title : parent::Title();
		}
	}

}
