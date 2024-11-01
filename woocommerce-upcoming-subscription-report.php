<?php
/**
 * Plugin Name:       Upcoming subscription reports 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Woocommerce Upcoming subscription reports lists all the upcoming/previous subscription dates and details in real-time dashboard, with fast reports.
 * Version:           1.0.2
 * Author:            StorePro
 * Author URI:        https://storepro.io/
 * Text Domain:       woocommerce-upcoming-subscription-reports
 */

/**
 * @package  UpcomingSubscriptionReport
 */

function UpcomingSubscriptionReport_plugin_enqueue_style() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'UpcomingSubscriptionReport-plugin-style',  $plugin_url . "css/style.css");
}
add_action( 'wp_enqueue_scripts', 'UpcomingSubscriptionReport_plugin_enqueue_style' );

/*
   Woocommerce Upcoming subscription reports lists all the upcoming/previous subscription dates and details in real-time dashboard, with fast reports.
    Copyright (C) 2021  StorePro

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );


define('UPSR_PLUGIN_URL', plugin_dir_url( __FILE__ ));
/**
 * Check if WooCommerce is active. if it isn't, disable Renewal Reminders.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if( !is_plugin_active( 'woocommerce/woocommerce.php') ){
    function upsr_is_woo_plugin_active() {
        ?>
        <div class="error notice">
            <p><?php _e( '<strong>WooCommerce Upcoming subscription reports</strong> is inactive. WooCommerce, WooCommerce Subscriptions plugins must be active for  Upcoming subscription report. Please install & activate WooCommerce & WooCommerce Subscriptions »', 'upsr-sp' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'upsr_is_woo_plugin_active' );
    deactivate_plugins(plugin_basename(__FILE__));
    return;
}

/**
 * Check if WooCommerce Subscriptions plugin is active. if it isn't, disable upcoming subscription reports.
 */
if( !is_plugin_active( 'woocommerce-subscriptions/woocommerce-subscriptions.php') ){
    function upsr_is_subscription_plugin_active() {
        ?>
        <div class="error notice">
            <p><?php _e( '<strong>WooCommerce Upcoming subscription reports</strong> is inactive. WooCommerce Subscriptions plugin must be active for upcoming subscription report to work. Please install & activate WooCommerce Subscriptions »', 'upsr-sp' ); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'upsr_is_subscription_plugin_active' );
    deactivate_plugins(plugin_basename(__FILE__));
    return;
}


/**
 * Woocommerce Version Check
 */
if(!function_exists('upsr_sp_wc_version_check')){
function upsr_sp_wc_version_check( $version = '3.0' ) {
	if ( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;
		if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}
	}
	return false;
}
}

/**
 * Define plugin directory path
 */
if (!defined('UPSR_PLUGIN_DIR'))
define('UPSR_PLUGIN_DIR', plugin_dir_path( __FILE__ ));


/*
 * The code that runs during plugin activation
 */
function activate_upsr_sp_plugin() {
	require_once UPSR_PLUGIN_DIR . 'inc/base/upcoming-subscription-report-activate.php';
	UpcomingSubscriptionReportsActivate::activate();
   
}
register_activation_hook( __FILE__, 'activate_upsr_sp_plugin' );


/**
 * The code that runs during plugin deactivation
 */
function deactivate_upsr_sp_plugin() {
	require_once UPSR_PLUGIN_DIR . 'inc/base/upcoming-subscription-report-deactivate.php';
	UpcomingSubscriptionReportsdeactivate::deactivate();
	//wp_clear_scheduled_hook( 'renewal_reminders' );
}
register_deactivation_hook( __FILE__, 'deactivate_upsr_sp_plugin' );


/**
 * Initialize all the core classes of the plugin
*/
require_once UPSR_PLUGIN_DIR . '/inc/init.php';
if ( class_exists( 'Init' ) ) 
{
	Init::get_services();
}

