<?php

class WPF_Autonami {

    /**
     * Lets pluggable functions know which features are supported by the CRM
     */
    public $supports;

    /**
     * Contains API params
     */
    public $params;

    /**
     * Autonami OAuth stuff
     */
    public $client_id;
    public $client_secret_us;
    public $client_secret_eu;
    public $client_secret_in;
    public $client_secret_au;
    public $api_domain;

    /**
     * Lets outside functions override the object type (Leads for example)
     */
    public $object_type;

    /**
     * Bypass the field filtering in WPF_CRM_Base so multiselects get sent as arrays
     */
    public $override_filters;

    /**
     * Get things started
     *
     * @access  public
     * @since   2.0
     */
    public function __construct() {

        $this->slug = 'autonami';
        $this->name = 'Autonami';
        $this->supports = array('add_tags', 'add_lists');


        $this->override_filters = true;

        // Set up admin options
        if (is_admin()) {
            require_once dirname(__FILE__) . '/admin/class-admin.php';
            new WPF_Autonami_Admin($this->slug, $this->name, $this);
        }
        
        // Error handling
    }

    /**
     * Sets up hooks specific to this CRM
     *
     * @access public
     * @return void
     */
    public function init() {
        add_filter('wpf_user_tags', array($this, 'afwf_wpf_user_tags'), 10, 3);
        add_filter('wpf_format_field_value', array($this, 'format_field_value'), 10, 3);
        add_filter('wpf_contact_id', array($this, 'afwf_wpf_contact_id'), 10, 3);
        
    }
    
    function afwf_wpf_contact_id($contact_id, $email_address){
        if(empty($contact_id)){
            if(!empty($email_address)){
                $contact_id = $this->get_contact_id($email_address);
                $user_id = get_user_by('email', $email_address);
                add_user_meta($user_id, "autonami_contact_id", $contact_id);
            }
            //add maybe na alternate logic
        }
        return $contact_id;
    }
    /**
     * Update user meta tags
     *
     * @access public
     * @return mixed
     */
    function afwf_wpf_user_tags($tags, $user_id){
        if($user_id != false){
            $user  = get_user_by( 'id', $user_id );
            if(!empty($user)){
                $contact_id = $this->get_contact_id($user->user_email);
                if(!empty($contact_id) && $contact_id > 0){
                    return $this->get_tags($contact_id);
                }
            }
        }
        
        return $tags;
        
        //$contact = new BWFCRM_Contact($user_id);
        //var_dump($contact);
        //die("r=".$user_id);
    }

    /**
     * Formats user entered data to match Autonami field formats
     *
     * @access public
     * @return mixed
     */
    public function format_field_value($value, $field_type, $field) {

        if ('datepicker' == $field_type || 'date' == $field_type) {

            if (!is_numeric($value)) {
                $value = strtotime($value);
            }

            // Adjust formatting for date fields (doesn't work with Date/time fields)
            $date = date('Y-m-d', $value);

            return $date;
        } elseif ('datetime' == $field_type) {

            if (!is_numeric($value)) {
                $value = strtotime($value);
            }

            // Works for Date/Time field
            $date = date('c', $value);

            return $date;
        } elseif ('checkbox' == $field_type || 'checkbox-full' == $field_type) {

            if (!empty($value)) {

                // If checkbox is selected
                return true;
            }
        } elseif ('text' == $field_type || 'textarea' == $field_type) {

            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            return strval($value);
        } elseif (( 'multiselect' == $field_type || 'checkboxes' == $field_type ) && !is_array($value)) {

            return array_map('trim', explode(',', $value));
        } else {

            return $value;
        }
    }

    /**
     * Gets params for API calls
     *
     * @access  public
     * @return  array Params
     */
    public function get_params($access_token = null) {
    }

    /**
     * Refresh an access token from a refresh token
     *
     * @access  public
     * @return  bool
     */
    public function refresh_token() {

    }

    /**
     * Check HTTP Response for errors and return WP_Error if found
     *
     * @access public
     * @return HTTP Response
     */
    public function handle_http_response($response, $args, $url) {

    }

    /**
     * Initialize connection
     *
     * @access  public
     * @return  bool
     */
    public function connect($access_token = null, $refresh_token = null, $test = false) {
        if (is_plugin_active("wp-marketing-automations/wp-marketing-automations.php")) {
            if (is_plugin_active("wp-marketing-automations-pro/wp-marketing-automations-pro.php")) {
                return true;
            }
        }
        return false;
    }

    /**
     * Performs initial sync once connection is configured
     *
     * @access public
     * @return bool
     */
    public function sync() {
        $this->connect();

        $this->sync_tags();
        $this->sync_crm_fields();
        $this->sync_layouts();
        $this->sync_users();

        do_action('wpf_sync');

        return true;
    }

    /**
     * Gets all available tags and saves them to options
     *
     * @access public
     * @return array Lists
     */
    public function sync_tags() {
        $available_tags = array();

        return $available_tags;
    }

    /**
     * Loads all custom fields from CRM and merges with local list
     *
     * @access public
     * @return array CRM Fields
     */
    public function sync_crm_fields() {
        $built_in_fields = array();
        $custom_fields = array();
        
        if(class_exists("BWFCRM_Fields")){
            $autonami_fields = BWFCRM_Fields::get_fields();

            if (!empty($autonami_fields)) {

                foreach ($autonami_fields as $id => $field) {

                    if (is_numeric($id)) {
                        $custom_fields[$id] = $field["name"];
                    } else {
                        $built_in_fields[$id] = $field;
                    }
                }
                if(!isset($built_in_fields['email'])){
                    $built_in_fields['email'] = 'Email';
                }
            }

            asort($built_in_fields);
            asort($custom_fields);
        }
            

        $crm_fields = array(
            'Standard Fields' => $built_in_fields,
            'Custom Fields' => $custom_fields,
        );

        wp_fusion()->settings->set('crm_fields', $crm_fields);

        return $crm_fields;
    }

    /**
     * Syncs available contact layouts
     *
     * @access public
     * @return array Layouts
     */
    public function sync_layouts() {

        $available_layouts = array();

        return $available_layouts;
    }

    /**
     * Syncs available contact owners
     *
     * @access public
     * @return array Owners
     */
    public function sync_users() {
        $available_users = array();
        if (class_exists("BWFCRM_Contact")) {
            $contacts = BWFCRM_Contact::get_contacts("", 0, 1000);
            $available_users = array();

            if (is_array($contacts['contacts'])) {
                foreach ($contacts['contacts'] as $user) {
                    $available_users[$user["id"]] = $user["f_name"] . ' ' . $user["l_name"];
                }
            }

            wp_fusion()->settings->set('autonami_users', $available_users);
        }
        return $available_users;
    }

    /**
     * Gets contact ID for a user based on email address
     *
     * @access public
     * @return int Contact ID
     */
    public function get_contact_id($email_address) {
        if(class_exists("BWFCRM_Contact")){
            $users = BWFCRM_Contact::get_contacts($email_address, 0, 1000);
            if (is_array($users['contacts'])) {
                foreach ($users['contacts'] as $user) {
                    if ($user['email'] == $email_address) {
                        return $user['id'];
                    }
                }
            }
        }
            
        return 0;
    }

    /**
     * Gets all tags currently applied to the user, also update the list of available tags
     *
     * @access public
     * @return void
     */
    public function get_tags($contact_id) {
        $tags = array();
        if(class_exists("BWFCRM_Contact")){
            $contact = new BWFCRM_Contact($contact_id);

            $autonami_tags = $contact->get_all_tags();

            if(is_array($autonami_tags)){
                foreach($autonami_tags as $tag){
                    $tags[] = $tag['name'];
                }
            }
            unset($contact);
        }
            
        return $tags;
    }

    /**
     * Applies tags to a contact
     *
     * @access public
     * @return bool
     */
    public function apply_tags($tags, $contact_id) {
        if(class_exists("BWFCRM_Contact")){
            $contact = new BWFCRM_Contact($contact_id);
            if(is_array($tags)){
                $a_tags = array();
                foreach($tags as $tag){
                    $a_tags[] = array('id' => '0', 'value' => $tag);
                }
                $added_tags = $contact->add_tags($a_tags);
            }


            return true;
        }
        return false;   
    }
    
    public function get_tag_id_by_name($tag_name){
        if(class_exists("BWFCRM_Tag")){
            $a_tags = BWFCRM_Tag::get_tags(array(), $tag_name);
            if(is_array($a_tags)){
                foreach($a_tags as $a_tag){
                    if($a_tag['name'] == $tag_name){
                        return $a_tag['ID'];
                    }
                }
            }
        }
        return 0;
    }

    /**
     * Removes tags from a contact
     *
     * @access public
     * @return bool
     */
    public function remove_tags($tags, $contact_id) {
        if(class_exists("BWFCRM_Contact")){
            $contact = new BWFCRM_Contact($contact_id);
            if(is_array($tags)){
                if(class_exists("BWFCRM_Tag")){
                    $a_tags = BWFCRM_Tag::get_tags();
                    $new_tags = array();
                    if(is_array($a_tags)){
                        foreach($a_tags as $a_tag){
                            if(in_array($a_tag['name'], $tags)){
                                $new_tags[] = $a_tag['ID'];
                            }
                        }
                    }
                    $remove_tags = $contact->remove_tags($new_tags);
                    return true;
                }
            }
        }
        return false;   
    }

    /**
     * Adds a new contact
     *
     * @access public
     * @return int Contact ID
     */
    public function add_contact($data, $map_meta_fields = true) {
        
        if (class_exists("BWFCRM_Contact")) {
            if ($map_meta_fields == true) {
                $data = wp_fusion()->crm_base->map_meta_fields($data);
            }
            $contact = new BWFCRM_Contact($data["email"], true, $data);

            return $contact->get_id();
        }
        return 0;
    }

    /**
     * Update contact
     *
     * @access public
     * @return bool
     */
    public function update_contact($contact_id, $data, $map_meta_fields = true) {
        if (class_exists("BWFCRM_Contact")) {
            if ($map_meta_fields == true) {
                $data = wp_fusion()->crm_base->map_meta_fields($data);
            }
            $contact = new BWFCRM_Contact($contact_id);
            $contact->update_contact($data);
            return true;
        }
        return false;
    }

    /**
     * Loads a contact and updates local user meta
     *
     * @access public
     * @return array User meta data that was returned
     */
    public function load_contact($contact_id) {
        if(class_exists("BWFCRM_Contact")){
            $contact = new BWFCRM_Contact($contact_id);
            if(!empty($contact)){
                $user = $contact->get_basic_array();
                $user["user_email"] = $user["email"];
                $user["user_id"] = $contact->contact->get_wpid();
                //$user["ID"] = $user["user_id"];
                return $user;
            }
        }
        return array();
    }

    /**
     * Gets a list of contact IDs based on tag
     *
     * @access public
     * @return array Contact IDs returned
     */
    public function load_contacts($tag) {
        $contact_ids = array();
        if(class_exists("BWFCRM_Contact")){
            $tag_ids = array();
            if(is_array($tag)){
                foreach($tag as $_tag){
                    $tag_ids[] = $this->get_tag_id_by_name($_tag);
                }
            }else{
                $tag_id = $this->get_tag_id_by_name($tag);
                $tag_ids = array($tag_id);
            }
            
            
            $tags = array("tags_contains" => $tag_ids);
            $users = BWFCRM_Contact::get_contacts("", 0, 1000, $tags);
            if (is_array($users['contacts'])) {
                foreach ($users['contacts'] as $user) {
                    $contact_ids[] = $user['id'];
                }
            }
        }

        return $contact_ids;
    }

}
