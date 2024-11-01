<?php

/**
 *  
 * @package  UpcomingSubscriptionReport
 * 
 */

class UpcomingSubscriptionReportsActivate
{
    public static function activate() 
    {
        flush_rewrite_rules();
    }
    
}