<?php

/**
 * Trigger this file on plugin uninstall
 * 
 * @package  UpcomingSubscriptionReport
 */



if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
    global $wpdb;
	$table_name = $wpdb->prefix . 'upcoming-subscription-report';
    $wpdb->query( "DROP TABLE IF EXISTS .'$table_name'" );
    delete_option("my_plugin_db_version");

