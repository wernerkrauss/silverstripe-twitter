<?php
if (class_exists('Widget')) {
	class SearchTwitterWidget extends TwitterWidget {
	
		private static $db = array(
			"Query" => "Varchar(255)"
		);
	
		public function CMSTitle() {
			return _t('SearchTwitterWidget.CMSTITLE', 'Twitter Search Feed');
		}
		
		public function Description() {
			return _t('SearchTwitterWidget.DESCRIPTION', 'Shows the searched twitter posts in the sidebar.');
		}
		
		function getCMSFields() {
			$this->beforeUpdateCMSFields(function(&$fields) {
				$fields->merge(array(
					new TextField('Query', _t('SearchTwitterWidget.FIELD_QUERY', 'Query'), null, 255)
				));
			});
	
			return parent::getCMSFields();
		}
	
		function getLatestTweets() {
			$controller = Controller::curr();
			return $controller->SearchTweets($this->Query, $this->TweetCount);
		}
	}
}
