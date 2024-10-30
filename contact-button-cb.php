<?php

/**
 * Plugin Name:       Contact Button - The All-in-One Website Widget
 * Plugin URI:        https://help.contactbutton.com/en
 * Description:       Convert website visitors into contacts with 15 easy to use Contact Button apps. Widget apps include, Contact Forms, Call Now Buttons and more!
 * Version:           1.0.2
 * Author:            Contact Button
 * Author URI:        https://contactbutton.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contact-button-cb
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


defined( 'CONTACT_BUTTON_CB_PATH' ) || define( 'CONTACT_BUTTON_CB_PATH', plugin_dir_path( __FILE__ ) );
defined( 'CONTACT_BUTTON_CB_URL' ) || define( 'CONTACT_BUTTON_CB_URL', plugin_dir_url( __FILE__ ) );
defined( 'CONTACT_BUTTON_CB_BASE' ) || define( 'CONTACT_BUTTON_CB_BASE', plugin_basename( __FILE__ ) );
$contact_button_cb_version = get_file_data(CONTACT_BUTTON_CB_PATH . basename(CONTACT_BUTTON_CB_BASE), array( 'Version' ), 'plugin');
$contact_button_cb_text_domain = get_file_data(CONTACT_BUTTON_CB_PATH . basename(CONTACT_BUTTON_CB_BASE), array( 'Text Domain' ), 'plugin');
$contact_button_cb_plugin_name = get_file_data(CONTACT_BUTTON_CB_PATH . basename(CONTACT_BUTTON_CB_BASE), array( 'Plugin Name' ), 'plugin');

/**
 * Currently plugin version.
 */
defined( 'CONTACT_BUTTON_CB_VERSION' ) || define( 'CONTACT_BUTTON_CB_VERSION', $contact_button_cb_version[0] );

/**
 * The unique identifier.
 */
defined( 'CONTACT_BUTTON_CB_DOMAIN' ) || define( 'CONTACT_BUTTON_CB_DOMAIN', $contact_button_cb_text_domain[0] );

/**
 * Plugin Name
 */
defined( 'CONTACT_BUTTON_CB_NAME' ) || define( 'CONTACT_BUTTON_CB_NAME', $contact_button_cb_plugin_name[0] );


/**
 * The code that runs during plugin activation.
*/
function contact_button_cb_activate() {
	require_once CONTACT_BUTTON_CB_PATH . 'includes/class-contact-button-cb-activator.php';
	CONTACT_BUTTON_CB_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function contact_button_cb_deactivate() {
	require_once CONTACT_BUTTON_CB_PATH . 'includes/class-contact-button-cb-deactivator.php';
	CONTACT_BUTTON_CB_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'contact_button_cb_activate' );
register_deactivation_hook( __FILE__, 'contact_button_cb_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require CONTACT_BUTTON_CB_PATH . 'includes/class-contact-button-cb.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function contact_button_cb_run() {

	$plugin = new CONTACT_BUTTON_CB();
	$plugin->run();
}
contact_button_cb_run();
