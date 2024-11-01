<?php
/**
 *DatePicker selection file
 */
class DatePicker_Range{

function __construct(){


    // include CSS/JS, in our case jQuery UI datepicker
    add_action( 'admin_enqueue_scripts', array( $this, 'jqueryui' ) );
  
    
}

/*
 * Add jQuery UI CSS and the datepicker script
 * Everything else should be already included in /wp-admin/ like jquery, jquery-ui-core etc
 * If you use WooCommerce, you can skip this function completely
 */
function jqueryui(){
    
   // wp_enqueue_style( 'jquery-ui', plugins_url('/assets/css/jquery-ui-min.css',__FILE__) );
    wp_enqueue_style( 'jquery-ui', UPSR_PLUGIN_URL . '/assets/css/jquery-ui-min.css' );
    wp_enqueue_script( 'jquery-ui-datepicker' );
  
}

/*
 * The main function that actually filters the posts
 */
       //not here! check callback page

}
new DatePicker_Range();

