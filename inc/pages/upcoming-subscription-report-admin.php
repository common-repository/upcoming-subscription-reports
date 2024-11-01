<?php 

/**
 * @package  UpcomingSubscriptionReport
*/

require UPSR_PLUGIN_DIR . 'inc/api/upcoming-subscription-report-api.php';
require UPSR_PLUGIN_DIR . 'inc/api/callbacks/upcoming-subscription-report-admin-callbacks.php';


/**
* 
*/
class USPRAdmin
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new UpsrAdminCallbacks();

		$this->setPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Upcoming Subscription Reports', 
				'menu_title' => 'Subscription Reports', 
				'capability' => 'manage_options', 
				'menu_slug' => 'upcoming-subscription-reports', 
				'callback' => array( $this->callbacks, 'uspr_adminDashboard' ), 
				'icon_url' => 'dashicons-list-view', 
				'position' => 110
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			
			array(
				'option_group' => 'storepro_options_group',
				'option_name' => 'uspr_search'
			),
		
			array(
				'option_group' => 'storepro_options_group',
				'option_name' => 'upsr_listings'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			
			array(
				'id' => 'upsr_storepro_admin_index_section_2',
				'title' => '',
				'callback' => array( $this->callbacks, 'uspr_spacingSection' ),
				'page' => 'upsr_sp_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			
		
				array(
					'id' => 'upsr_Pagination',
					'title' => '',
					'callback' => array( $this->callbacks, 'uspr_UpcomingTableListings' ),
					'page' => 'upsr_sp_plugin',
					'section' => 'upsr_storepro_admin_index_section_2',
					'args' => array(
						'label_for' => 'uspr_Pagination',
						'class' => 'uspr_table_bg uspr_inline_tab uspr_page_align'
					)
					)


		);

		$this->settings->setFields( $args );
	}

}