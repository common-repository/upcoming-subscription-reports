<?php 
/**
 * @package  UpcomingSubscriptionReport
 */



/**
* 
*/
class UPSREnqueue extends UPSRBaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_files' ) );
	}
	
	 public function enqueue_files() {


		

		// Check user logged && and confirm page
		
		if ( is_user_logged_in()  ) {


		if ( isset($_GET['page']) ) {
			global $pagenow;
			
			if( in_array( $pagenow, array('admin.php','upcoming-subscription-report') ) && ( $_GET['page'] == 'admin.php' || $_GET['page'] == 'upcoming-subscription-report' ) ) {
		}



				// enqueue all our scripts and css
				
		
			wp_enqueue_style( 'uspr_mypluginstyle',  UPSR_PLUGIN_URL . 'assets/css/style.css' );		
			wp_enqueue_style( 'uspr_mypluginstyle_jq',  UPSR_PLUGIN_URL . 'assets/css/jquery.dataTables.min.css' );

			wp_enqueue_script( 'uspr_mypluginscript_jq', UPSR_PLUGIN_URL . "assets/js/jquery.dataTables.min.js", array(), '1.0.0', true );	
			wp_enqueue_script( 'uspr_mypluginscript',   UPSR_PLUGIN_URL . '/assets/js/ajax-script.js', array(), '1.0.1', true );
			


	}

		
		}
	
		
		
	}
	
}