<?php
/**
 * Plugin Name: Autonami Connector for WP-fusion
 * Plugin URI: https://evermoresuccess.com/
 * Description: This plug-in added Autonami 2.0 CRM for WP-fusion.
 * Version: 1.0.0
 * Author: Evermore Success
 * Author URI: https://evermoresuccess.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

define("AFWF_VERSION", "1.0.0");
define("AFWF_URL", plugins_url('', __FILE__) . "/");
define("AFWF_DIR", dirname(__FILE__) . "/");
define("AFWF_CONTROLLER_DIR", AFWF_DIR . "controller/");
define("AFWF_HELPERS_DIR", AFWF_DIR . "helpers/");
define("AFWF_VIEWS_DIR", AFWF_DIR . "views/");
define("AFWF_PAGE_ID_PREFIX", "afwf.");
define("AFWF_CSS_URL", AFWF_URL . "css/");
define("AFWF_JS_URL", AFWF_URL . "js/");
define("AFWF_IMAGES_URL", AFWF_URL . "images/");



require_once( AFWF_DIR . 'core/plugins.core.php');
require_once( AFWF_CONTROLLER_DIR . AFWF_PAGE_ID_PREFIX . 'base.php');
require_once( AFWF_CONTROLLER_DIR . AFWF_PAGE_ID_PREFIX . 'class.php');
require_once( AFWF_DIR .  'crm/autonami/class-autonami.php');

$afwf = new autonami_for_wp_fusion();

register_activation_hook(__FILE__, array($afwf, 'afwf_activate'));
register_deactivation_hook(__FILE__, array($afwf, 'afwf_deactivate'));
?>
