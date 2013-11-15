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
			$userNameField = new TextField('TwitterUsername', _t('TwitterSiteConfig.FIELD_TWITTER_USERNAME', 'Twitter Username'), null, 255),
			new TextField('TwitterAppConsumerKey', _t('TwitterSiteConfig.FIELD_CONSUMER_KEY', 'Consumer Key'), null, 255),
			new TextField('TwitterAppConsumerSecret', _t('TwitterSiteConfig.FIELD_CONSUMER_SECRET', 'Consumer Secret'), null, 255),
			new TextField('TwitterAppAccessToken', _t('TwitterSiteConfig.FIELD_ACCESS_TOKEN', 'Access Token'), null, 255),
			new TextField('TwitterAppAccessSecret', _t('TwitterSiteConfig.FIELD_ACCESS_SECRET' ,'Access Secret'), null, 255)
		));
		$userNameField->setDescription(_t('TwitterSiteConfig.FIELD_TWITTER_USERNAME_DESCRIPTION', 'Leave blank to disable twitter'));
	}
}
