<?php

/**
 * The file that defines the core plugin class
 *
 * @link       https://contactbutton.com
 * @since      1.0.0
 *
*/

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 */
class CONTACT_BUTTON_CB {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      CONTACT_BUTTON_CB_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

    /**
	 * The helper class
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      CONTACT_BUTTON_CB_HELPER    $helper    A helper class.
	 */
	protected $helper;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
        $this->helper = new CONTACT_BUTTON_CB_HELPER();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

        /**
		 * The class responsible with commom functions
		 */
        require_once CONTACT_BUTTON_CB_PATH . 'includes/class-contact-button-cb-helper.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once CONTACT_BUTTON_CB_PATH . 'includes/class-contact-button-cb-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once CONTACT_BUTTON_CB_PATH . 'includes/class-contact-button-cb-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once CONTACT_BUTTON_CB_PATH . 'admin/class-contact-button-cb-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once CONTACT_BUTTON_CB_PATH . 'public/class-contact-button-cb-public.php';

		$this->loader = new CONTACT_BUTTON_CB_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new CONTACT_BUTTON_CB_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new CONTACT_BUTTON_CB_Admin($this->helper);

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'settings_menu' );
        $this->loader->add_action( 'init', $plugin_admin, 'verify_and_save_settings', 10 );
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'not_activated_notice');
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'activated_notice');
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'save_settings_notice');
        $this->loader->add_action( 'admin_head', $plugin_admin, 'custom_menu_icon_css');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new CONTACT_BUTTON_CB_Public($this->helper);
        $this->loader->add_action( 'wp_head', $plugin_public, 'print_script');
        $this->loader->add_action( 'enqueue_scripts', $plugin_public, 'print_script' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    CONTACT_BUTTON_CB_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
}
