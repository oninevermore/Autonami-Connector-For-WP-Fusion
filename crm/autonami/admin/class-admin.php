<?php

class WPF_Autonami_Admin {

	private $slug;
	private $name;
	private $crm;

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function __construct( $slug, $name, $crm ) {
		$this->slug = $slug;
		$this->name = $name;
		$this->crm  = $crm;

		// Settings
		add_filter( 'wpf_configure_settings', array( $this, 'register_connection_settings' ), 15, 2 );
		add_action( 'show_field_autonami_header_begin', array( $this, 'show_field_autonami_header_begin' ), 10, 2 );

		// AJAX
		add_action( 'wp_ajax_wpf_test_connection_' . $this->slug, array( $this, 'test_connection' ) );

		if ( wp_fusion()->settings->get( 'crm' ) == $this->slug ) {
			$this->init();
		}

		// OAuth
		add_action( 'admin_init', array( $this, 'maybe_oauth_complete' ) );
                
                
                //$this->check_autonami_installation();
                add_action( 'admin_init', array( $this, 'check_autonami_installation' ) );
	}

	/**
	 * Hooks to run when this CRM is selected as active
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function init() {
                add_filter('pre_option_autonami_users', array($this, 'afwf_autonami_users'));
                add_filter('pre_option_wpf_available_tags', array($this, 'afwf_wpf_available_tags'));
                add_filter('pre_option_available_lists', array($this, 'afwf_available_lists'));
		add_filter( 'wpf_initialize_options', array( $this, 'add_default_fields' ), 10 );
		add_filter( 'wpf_configure_settings', array( $this, 'register_settings' ), 10, 2 );
                add_action('admin_head', array($this, 'head_script'), 1);
                
                //print_r(BWFCRM_Fields::get_fields());
                //die();
	}
        
        public function check_autonami_installation(){
            if(isset($_GET["action"]) && $_GET["action"] == "check_autonami_installation"){
                if ( is_plugin_active("wp-marketing-automations/wp-marketing-automations.php") ) {
                    $options                          = wp_fusion()->settings->get_all();
                    $options['autonami_installed']    = true;
                    $options['crm']                   = $this->slug;
                    //$options['connection_configured'] = true;

                    wp_fusion()->settings->set_all( $options );
                    wp_redirect( get_admin_url() . 'options-general.php?page=wpf-settings#setup' );
                }else{
                    wp_redirect( get_admin_url() . 'options-general.php?page=wpf-settings&status=failed#setup' );
                }
            }
        }
        
        function afwf_wpf_available_tags(){
            $new_tags = array();
            if(class_exists("BWFCRM_Tag")){
                $tags = BWFCRM_Tag::get_tags();

                if(is_array($tags)){
                    foreach($tags as $tag){
                        $new_tags[$tag['name']] = $tag['name'];
                    }
                }
            }
                
            return $new_tags;
        }
        
        function afwf_available_lists(){
            $lists = BWFCRM_Lists::get_lists();
            $new_lists = array();
            if(is_array($lists)){
                foreach($lists as $list){
                    $new_lists[$list['ID']] = $list['name'];
                }
            }
            return $new_lists;
        }
        
        function afwf_autonami_users(){
            $users = BWFCRM_Contact::get_contacts( '', 0, 1000);
            $new_users = array();
            if(is_array($users['contacts'])){
                foreach($users['contacts'] as $user){
                    $new_users[$user['id']] = $user['f_name'] . ' ' . $user['l_name'];
                }
            }
            return $new_users;
        }
        
        
        function head_script(){
            //echo '<style>#header-resync,#tab-import,#import{display:none}</style>';
        }
        

        /**
	 * Hooks to run when this CRM is selected as active
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function maybe_oauth_complete() {

		

	}


	/**
	 * Loads Autonami connection information on settings page
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function register_connection_settings( $settings, $options ) {

		$new_settings = array();

		$new_settings['autonami_header'] = array(
			'title'   => __( 'Autonami Configuration', 'wp-fusion' ),
			'std'     => 0,
			'type'    => 'heading',
			'section' => 'setup',
		);

		$auth_url = get_admin_url()  . "options-general.php?page=wpf-settings&action=check_autonami_installation";

		if ( empty( $options['autonami_installed'] ))  {

			$new_settings['autonami_header']['desc'] = '<table class="form-table"><tr>';
			$new_settings['autonami_header']['desc'] .= '<th scope="row"><label>Validate</label></th>';
			$new_settings['autonami_header']['desc'] .= '<td><a class="button button-primary" href="' . $auth_url . '">Check Autonami Installation</a><br /><span class="description">This will validate if Autonami was successfully installed.</td>';
			$new_settings['autonami_header']['desc'] .= '</tr></table></div><table class="form-table">';

		} else {
//                        $new_settings['autonami_header']['desc'] = '<table class="form-table"><tr>';
//			$new_settings['autonami_header']['desc'] .= '<th scope="row"><label>'.($_GET['status'] == 'failed' ? 'Status' : 'Refresh').'</label></th>';
//                        if($_GET['status'] == 'failed'){
//                            $new_settings['autonami_header']['desc'] .= '<td><a class="button" style="background-color:red;color:white;border-color:white">Autonami Plugin was not installed yet</a><br /><span class="description">Please install first the Autonami plugin.</td>';
//                        }else{
//                            $new_settings['autonami_header']['desc'] .= '<td><a class="button button-primary" href="' . $auth_url . '">Refresh Checking Autonami Installation</a><br /><span class="description">This will re-validate if Autonami was successfully installed.</td>';
//                        }
//			
//			$new_settings['autonami_header']['desc'] .= '</tr></table></div><table class="form-table">';
                        
			$new_settings['autonami_refresh_token'] = array(
				'title'       => __( 'Refresh data', 'wp-fusion' ),
				'type'        => 'api_validate',
				'section'     => 'setup',
				'class'       => 'api_key hide',
				'post_fields' => array( 'autonami_token', 'autonami_refresh_token' ),
				'desc'        => 'This will refresh Autonami tags & fields',
			);

		}

		$settings = wp_fusion()->settings->insert_setting_after( 'crm', $settings, $new_settings );

		return $settings;

	}

	/**
	 * Adds Autonami specific setting fields
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function register_settings( $settings, $options ) {

		$new_settings = array();

		if ( ! isset( $options['autonami_layouts'] ) ) {
			$options['autonami_layouts'] = array();
		}

		$new_settings['autonami_layout'] = array(
			'title'       => __( 'Contact Layout', 'wp-fusion' ),
			'desc'        => __( 'Select a layout to be used for new contacts.', 'wp-fusion' ),
			'type'        => 'select',
			'placeholder' => __( 'Select layout', 'wp-fusion' ),
			'section'     => 'main',
			'choices'     => $options['autonami_layouts'],
		);

		if ( ! empty( $options['autonami_users'] ) ) {

			$new_settings['autonami_owner'] = array(
				'title'       => __( 'Contact Owner', 'wp-fusion' ),
				'desc'        => __( 'Select an owner to be used for new contacts.', 'wp-fusion' ),
				'std'         => false,
				'type'        => 'select',
				'placeholder' => __( 'Select owner', 'wp-fusion' ),
				'section'     => 'main',
				'choices'     => $options['autonami_users'],
			);

		}

		$settings = wp_fusion()->settings->insert_setting_after( 'create_users', $settings, $new_settings );

		$new_settings = array(
			'import_notice' => array(
				'desc'        => __( '<strong>Note:</strong> Imports with Autonami use a loose word match on the contact record. That means if your import tag is "gmail", it will also import any contacts with an <em>@gmail.com</em> email address. Please use a unique tag name for imports.', 'wp-fusion' ),
				'type'        => 'paragraph',
				'section'     => 'import',
			)
		);

		$settings = wp_fusion()->settings->insert_setting_after( 'import_users', $settings, $new_settings );

		return $settings;

	}


	/**
	 * Loads standard Autonami field names and attempts to match them up with standard local ones
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function add_default_fields( $options ) {
		if ( $options['connection_configured'] == true ) {

			require_once dirname( __FILE__ ) . '/autonami-fields.php';

			foreach ( $options['contact_fields'] as $field => $data ) {

				if ( isset( $autonami_fields[ $field ] ) && empty( $options['contact_fields'][ $field ]['crm_field'] ) ) {
					$options['contact_fields'][ $field ] = array_merge( $options['contact_fields'][ $field ], $autonami_fields[ $field ] );
				}

			}

		}
                
		return $options;

	}


	/**
	 * Puts a div around the Autonami configuration section so it can be toggled
	 *
	 * @access  public
	 * @since   1.0
	 */

	public function show_field_autonami_header_begin( $id, $field ) {
		echo '</table>';
		$crm = wp_fusion()->settings->get( 'crm' );
		echo '<div id="' . $this->slug . '" class="crm-config ' . ( $crm == false || $crm != $this->slug ? 'hidden' : 'crm-active' ) . '" data-name="' . $this->name . '" data-crm="' . $this->slug . '">';

	}


	/**
	 * Verify connection credentials
	 *
	 * @access public
	 * @return bool
	 */

	public function test_connection() {
		if ( is_plugin_active("wp-marketing-automations/wp-marketing-automations.php") ) {
                    if ( is_plugin_active("wp-marketing-automations-pro/wp-marketing-automations-pro.php") ) {
                        $options                          = wp_fusion()->settings->get_all();
			$options['autonami_installed']    = true;
			$options['crm']                   = $this->slug;
			$options['connection_configured'] = true;

			wp_fusion()->settings->set_all( $options );

			wp_send_json_success();
                    }else{
                        wp_send_json_error( "Autonami pro version isn't installed yet." );
                    }

		} else {
                        wp_send_json_error( "Autonami plugin isn't installed yet." );

		}

		die();

	}


}