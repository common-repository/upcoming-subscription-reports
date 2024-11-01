<?php

/**
 * @package  UpcomingSubscriptionReport
 */

/**
 * Include upcoming-subscription-report-admin-post-filter.php
 */

require_once( UPSR_PLUGIN_DIR . 'inc/api/callbacks/upcoming-subscription-report-admin-post-filter.php' );

class UpsrAdminCallbacks
{
    public function uspr_sp_refresh()

    {
        echo '<p class="uspr_padding_bottom"></p>';
       
    }

    public function uspr_adminDashboard()
    {
        return require UPSR_PLUGIN_DIR . 'templates/upcoming-subscription-report-admin.php';
    }

    public function uspr_sp_OptionsGroup($input)
    {
        return $input;
    }

    public function uspr_spacingSection()
    {
                echo '<p class="uspr_padding_bottom"></p>';
               
    }

        
        

    public function uspr_UpcomingTableListings() 
    {

        global $wpdb;
        
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}upcoming_subscription_report"); 
        if(!empty($results))   
                
             {    
                
            echo '   <table border="0" cellspacing="5" cellpadding="5" id="uspr-datatable">
                 <tbody>

                 <tr class="upsr-select">
                <td ><select name="ChoosePayments" id="payment-selector-top">
                <option  value="all" >All Payments</option>
                <option  value="5" >Next Payments</option>
                <option  value="4" >Previous Payments</option>
                </select></td>
                <td><input name="min" id="uspr_min_value_text" type="text" placeholder="From" autocomplete="off"></td>
                <td><input name="max" id="uspr_max_value_text" type="text" placeholder="To" autocomplete="off"></td>
                <td>
            
                
                <button id="upsr_filter_clear" class="upsr_button_clear" onclick="ClearFields();">Clear</button>
                <button id="uspr_btn_refersh_data" class="upsr_button_refresh_data" onClick="RefreshButton();" >Refresh</button>
                </td>

            
                 </tr>
                 </tbody>
                 </table><table width="100%" class="display" id="uspr-thead-table" cellspacing="0">
                 <thead>
                  <tr>
            
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Previous Payment</th>
                    <th>Next Payment</th>
                 </tr>
                 </thead>
                <tfoot>
                  <tr>
                
                <th>ID</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Total</th>
                <th>Previous Payment</th>
                <th>Next Payment</th>
                  </tr>
                 </tfoot>
                <tbody>';

        foreach($results as $row){   

         echo' <tr>';
                echo   '<td><a href="' .esc_html($row->subscription_link) . '">'. esc_html($row->subscription_id) .'</td>';
                echo  ' <td>' .esc_html($row->subscriber_name) .'</td>';
                echo   '<td ><a href="'.esc_html($row->product_link) . '">' .esc_html($row->subscription_items).'</td>';
                echo  ' <td>$' .esc_html($row->subscription_total) .'/month</td>';
                echo  '<td>' .esc_html($row->previous_payment_date) .'</td>';
                echo ' <td>' .esc_html($row->next_payment_date) .'</td>';
            
         echo  '</tr>';

                 }

         echo '
                </tbody>
                 </table>';

             }

         echo "</div> </div>";
        

      }
 }





