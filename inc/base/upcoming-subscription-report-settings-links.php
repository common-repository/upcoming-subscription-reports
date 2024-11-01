<?php
/**
 * @package  UpcomingSubscriptionReport
 */


class UPSRSettingsLinks extends UPSRBaseController
{

	public function register() 
	{
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=upcoming-subscription-report">Settings</a>';
		array_push( $links, $settings_link );
		//echo 'prnv_mtn';

		return $links;
	}

}