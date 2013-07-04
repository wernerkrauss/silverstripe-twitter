<?php

/**
 * Sets twitter configuration in the SiteConfig
 * 
 * @author Damian Mooyman
 * 
 * @package twitter
 */
class TwitterSiteConfig extends DataExtension {
	
	private static $db = array(
		'TwitterUsername' => 'Varchar(255)',
		'TwitterAppConsumerKey' => 'Varchar(255)',
		'TwitterAppConsumerSecret' => 'Varchar(255)',
		'TwitterAppAccessToken' => 'Varchar(255)',
		'TwitterAppAccessSecret' => 'Varchar(255)'
	);
	
	public function updateCMSFields(FieldList $fields) {
		
		// Twitter setup
		$fields->addFieldsToTab('Root.TwitterApp', array(
			$userNameField = new TextField('TwitterUsername', 'Twitter Username', null, 255),
			new TextField('TwitterAppConsumerKey', 'Consumer Key', null, 255),
			new TextField('TwitterAppConsumerSecret', 'Consumer Secret', null, 255),
			new TextField('TwitterAppAccessToken', 'Access Token', null, 255),
			new TextField('TwitterAppAccessSecret', 'Access Secret', null, 255)
		));
		$userNameField->setDescription('Leave blank to disable twitter');
	}
}
