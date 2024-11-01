<?php 
/**
 * @package  UpcomingSubscriptionReport
 * 
 */

class UPSRTableOperations 
{
  public function upsr_table_operations() 
	{
    $this->upsr_create_table();
    add_action( 'wp_loaded', array($this, 'active_subscription_list') );
  }

  public function upsr_create_table()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . "upcoming_subscription_report"; 
    $charset_collate = $wpdb->get_charset_collate();

    #Check to see if the table exists already, if not, then create it
    if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) 
    {
      $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        subscription_id mediumint(9) NOT NULL,
        subscriber_name text NOT NULL,
        subscription_items text NOT NULL,
        subscription_iems_id text NOT NULL,
        billing_period text NOT NULL,
        subscription_link text NOT NULL,
        product_link text NOT NULL,
        subscription_total mediumint(9) NOT NULL,
        next_payment_date date DEFAULT '0000-00-00' NOT NULL,
        previous_payment_date date DEFAULT '0000-00-00' NOT NULL,
       
        


        PRIMARY KEY  (id)
      ) $charset_collate;";          
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );  
    }
  } 

  /**
   * Function to fetch active subscription details
   */
  public function active_subscription_list($from_date=null, $to_date=null) 
  {
    global $wpdb, $woocommerce;
    $table_name = $wpdb->prefix . "upcoming_subscription_report"; 
    $subscriptions = wcs_get_subscriptions(['subscriptions_per_page' => -1]);
    $db_count = 0;
    
     //Going through each current customer orders
    foreach ( $subscriptions as $subscription ) {
      $subscription_data = wcs_get_subscription( $subscription );
      $subscription_id = $subscription->get_ID();
      $customer_id = $subscription->get_user_id();
      $billing_first_name = $subscription-> get_billing_first_name();
      $billing_last_name  = $subscription-> get_billing_last_name();
      $customer_name = $billing_first_name . ' ' . $billing_last_name;
      $next_payment_date_dt = $subscription-> get_date( 'next_payment' );
      if($next_payment_date_dt){
              $next_payment_date = date( 'Y-m-d', strtotime( $next_payment_date_dt ) );
            }else{
                $next_payment_date = '0000-00-00';
      }
      $previous_payment_date_dt = $subscription-> get_date( 'last_order_date_created' );
      if ($previous_payment_date_dt){
        $previous_payment_date = date( 'Y-m-d', strtotime( $previous_payment_date_dt ) );
      }
      else{
        $previous_payment_date = '0000-00-00';
      }
      $subscription_order = wc_get_order($subscription_id);
      $subscription_total = $subscription->get_total();
      $subscription_items = $subscription->get_items();

   
      $period = $subscription->get_billing_period();
      if ( sizeof( $subscription_items = $subscription->get_items() ) > 0 ) {
        foreach ( $subscription_items as $item_id => $item ) {
          $subscription_iems_id = wcs_get_canonical_product_id( $item ); 
        $subscribed_product = $item->get_product();
        // $product->get_sku();
        
        // $subcribed_product_link = get_edit_post_link($subscribed_product_id);
    }

      //get product permalink
      $product_l = wc_get_product( $subscription_iems_id );
      $permalink_p = $product_l->get_permalink();

      //get subscription permalink
      
       $subscription_link = get_edit_post_link($subscription_id);
  

      
      $subscription_details = $wpdb->get_results("SELECT next_payment_date FROM $table_name WHERE subscription_id = $subscription_id ");
        if ( $subscription->get_status() == 'active' ) 
        {
          if($subscription_details ) 
            {
              $wpdb->update($table_name, array('next_payment_date'=>$next_payment_date), array('subscription_id'=>$subscription_id));
            }else{

     foreach( $subscription->get_items() as $item_id => $product_subscription ){
    // Get the name
    $product_name = $product_subscription->get_name();
    
    
              $wpdb->insert( 
                $table_name, 
                array( 
                  'subscription_id' => $subscription_id, 
                  'subscriber_name' => $customer_name, 
                  'subscription_items' => $product_name,
                  'next_payment_date' => $next_payment_date,
                  'previous_payment_date' =>$previous_payment_date,
                 
                  'subscription_total' => $subscription_total,
                  'billing_period' => $period,
                  'subscription_link' => $subscription_link,
                  'product_link' => $permalink_p,
                  //'currency' => $currency,
                  
                ) 
              );
            }
        }
        }elseif( $subscription->get_status() == 'cancelled' || $subscription->get_status() == 'expired' ) {
          $wpdb->delete($table_name,  array('subscription_id'=>$subscription_id));
        }
      }
    } 
  } 
}