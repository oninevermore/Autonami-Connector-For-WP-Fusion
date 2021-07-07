<?php

class autofusion {

    /**
	 * Allows for direct access to the API, bypassing WP Fusion
	 */

	public $app;

	/**
	 * Lets pluggable functions know which features are supported by the CRM
	 */

	public $supports;

	/**
	 * HTTP API parameters
	 */

	public $params;

	/**
	 * API url for the account
	 */

	public $api_url;

	/**
	 * Lets us link directly to editing a contact record.
	 *
	 * @var string
	 * @since 3.36.5
	 */

	public $edit_url = '';

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   2.0
	 */

	public function __construct() {

		$this->slug     = 'autonami';
		$this->name     = 'Autonami';
		$this->supports = array( 'add_tags', 'add_lists' );
                //wp_fusion()->settings->set( 'connection_configured', true );
		//$this->api_url  = wp_fusion()->settings->get( 'ac_url' );
	}
        
        public function init(){
            
        }

}
