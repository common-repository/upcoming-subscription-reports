<?php

/**
 *  
 * @package  UpcomingSubscriptionReport
 * 
 */

class UpcomingSubscriptionReportsdeactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}