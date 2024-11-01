<div class="uspr_wrapper">
	<h1 class="upsr_main_title">WooCommerce Upcoming Subscription Reports</h1>
	<?php settings_errors(); 

	
			// settings_fields( 'storepro_options_group' );
			do_settings_sections( 'upsr_sp_plugin' );
			
	
	?>
	<span class="upsr_logo_text"><a href="http://storepro.io/" target="_blank"> <img src="<?php echo UPSR_PLUGIN_URL?>./assets/images/storepro-logo.png"></a></span>
</div>
