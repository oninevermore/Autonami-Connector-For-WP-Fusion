<?php

class autonami_for_wp_fusion {

    function __construct() {
        if (!function_exists('wp_get_current_user')) {
            require ABSPATH . WPINC . '/pluggable.php';
        }
        if (isset($_REQUEST["ajax"])) {
            $this->afwf_voting_admin_control();
        } else {
            $this->init();
        }
    }

    function init() {
        add_filter('wpf_crms', array($this, 'afwf_add_autonami'));
        if (!is_admin()) {
            add_action('init', array($this, 'afwf_main_js_css'));
        } else {
            
            //add_action('admin_init', array($this, 'afwf_admin_js_css'));
            add_action('admin_init', array($this, 'afwf_activate_redirect'));
        }
    }
    
    function afwf_add_autonami($crm){
        $crm['autonami'] = 'WPF_Autonami';
        return $crm;
    }   
    
    function afwf_shared_js_css(){
        
    }
    
    function afwf_main_js_css(){
        
    }

    function afwf_admin_control() {
        $include_file = AFWF_CONTROLLER_DIR . $_REQUEST["page"];
        if (file_exists($include_file)) {
            require($include_file);
        } else {
            //echo("Unable to locate PATH: " . $include_file);
        }
    }

    function afwf_activate() {
        add_option(AFWF_FUNCTION_PREFIX . 'do_activation_redirect', true);
    }

    function afwf_activate_redirect() {
        if (get_option('afwf_do_activation_redirect', false)) {
            delete_option('afwf_do_activation_redirect');
            //exit(wp_redirect(admin_url('admin.php?page=ideas.voting.statistics.php')));
        }
    }

    function afwf_deactivate() {
        //add extra functionality when needed
    }

}
