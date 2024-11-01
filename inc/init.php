<?php

/**
 *  
 * @package  UpcomingSubscriptionReport
 * 
 */

require UPSR_PLUGIN_DIR . 'inc/base/upcoming-subscription-report-base-controller.php';
require UPSR_PLUGIN_DIR . 'inc/pages/upcoming-subscription-report-admin.php';
require UPSR_PLUGIN_DIR . 'inc/base/upcoming-subscription-report-enqueue.php';
require UPSR_PLUGIN_DIR . 'inc/base/upcoming-subscription-report-settings-links.php';
require UPSR_PLUGIN_DIR . 'inc/base/upcoming-subscription-report-table-operations.php';



final class Init
{
	/**
	 * Store all the classes inside an aUPSRay
	 * @return aUPSRay Full list of classes
	 */
	public static function get_services() 
	{

		$UPSRSettingsLinks = new UPSRSettingsLinks;  
		$UPSRSettingsLinks->register();

		$Admin = new USPRAdmin; 
		$Admin->register();

		$Enqueue = new UPSREnqueue;  
		$Enqueue->register();

		$TableOperations = new UPSRTableOperations;  
		$TableOperations->upsr_table_operations();


	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @return
	 */
	public static function register_services() 
	{
		foreach ( self::get_services() as $class ) 
		{
			$service = self::instantiate( $class );

			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}

			if ( method_exists( $service, 'tableoperations' ) ) {
				$service->tableoperations();
			}

			

		}
	}


	/**
	 * Initialize the class
	 * @param  class $class    class from the services aUPSRay
	 * @return class instance  new instance of the class
	 */
	private static function instantiate( $class )
	{
		$service = new $class();
		return $service;
	}


}