<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://contactbutton.com
 * @since      1.0.0
 *
 */
/**
 * The admin-specific functionality of the plugin.
 *
 */
class CONTACT_BUTTON_CB_Admin {

    /**
    	* helper
		*
    	* @var mixed
    */
    public $helper;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $helper ) {
        $this->helper = $helper;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
        if (self::is_contact_button_page()) {
		    wp_enqueue_style( CONTACT_BUTTON_CB_DOMAIN, CONTACT_BUTTON_CB_URL . 'admin/css/contact-button-admin.css', array(), filemtime(CONTACT_BUTTON_CB_PATH . 'admin/css/contact-button-admin.css'), 'all' );
        }
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
        if (self::is_contact_button_page()) {
		    wp_enqueue_script( CONTACT_BUTTON_CB_DOMAIN, CONTACT_BUTTON_CB_URL . 'admin/js/contact-button-admin.js', array( 'jquery' ), filemtime(CONTACT_BUTTON_CB_PATH . 'admin/js/contact-button-admin.js'), false );
        }
	}

    public function settings_menu() {
        add_menu_page(
            __( 'Contact Button', 'contact-button-cb' ),
            __( 'Contact Button', 'contact-button-cb' ),
            'manage_options',
            'contact-button-cb-settings',
            array( $this, 'content_callback' ),
            '',
            81
        );
    }

    public function content_callback() {
        if ( ! current_user_can('manage_options') ) {
			return;
		}
        $contact_button_id = get_option('contact-button-id');
        $in_header = $this->helper->is_in_header();
        require_once CONTACT_BUTTON_CB_PATH . 'admin/partials/contact-button-display.php';
    }

    public function verify_and_save_settings() {
        if (isset($_POST['nonce-contact-button-save']) && wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['nonce-contact-button-save'])), 'contact-button-save')) {
            if ( isset($_POST['contact-button-id']) ) {
                $contact_button_id = sanitize_text_field($_POST['contact-button-id']);
                update_option('contact-button-id', $contact_button_id);
                $response = wp_remote_post(
                    'https://app.contactbutton.com/check/script',
                    array(
                        'body'        => array(
                            'slug' => $contact_button_id,
                        ),
                        'method'      => 'POST',
                        'timeout'     => 20,
                        'redirection' => 5,
                        'httpversion' => '1.1',
                        'headers'     => array(),
                    )
                );
                if ( is_wp_error( $response ) ) {
                    $error_message = $response->get_error_message();
                    update_option('contact-button-cb-verify-status', 'error');
                    update_option('contact-button-cb-verify-curl-body', $error_message);
                } else {
                    $response_array = json_decode( wp_remote_retrieve_body( $response ), true );
                    if ( isset($response_array['status']) && 'success' === $response_array['status'] ) {
                        update_option('contact-button-cb-verify-status', 'success');
                    } else {
                        update_option('contact-button-cb-verify-status', 'error');
                        update_option('contact-button-cb-verify-curl-body', $response_array);
                    }
                }
            } else {
                update_option('contact-button-cb-verify-status', 'error');
                update_option('contact-button-id', '');
            }

            if ( isset($_POST['load-contact-button-code-in-header']) ) {
                update_option('contact-button-cb-in-header', 'header');
            } else {
                update_option('contact-button-cb-in-header', false);
            }
        }
    }

    /**
     * save_settings_notice
     *
     * @return void
     */
    public function save_settings_notice() {
        if (isset($_POST['nonce-contact-button-save']) && wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['nonce-contact-button-save'])), 'contact-button-save')) {
            printf(
                '<div class="notice notice-info is-dismissible"><p><strong>%s:</strong> %s</p></div>',
                esc_html( CONTACT_BUTTON_CB_NAME ),
                esc_html__('Settings successfully updated', 'contact-button-cb')
            );
        }
    }

    public function not_activated_notice() {
        if ( self::is_contact_button_page() && ! $this->helper::is_active() ) {
            printf(
                '<div class="notice notice-error"><p><strong>%s:</strong> %s</p></div>',
                esc_html( CONTACT_BUTTON_CB_NAME ),
                esc_html__('The button is not verified, insert the Contact Button ID and click Save and Verify', 'contact-button-cb')
            );
        }
    }

    public function activated_notice() {
        if ( self::is_contact_button_page() && $this->helper::is_active() ) {
            printf(
                '<div class="notice notice-success"><p><strong>%s:</strong> %s</p></div>',
                esc_html( CONTACT_BUTTON_CB_NAME ),
                esc_html__('The button is verified!', 'contact-button-cb')
            );
        }
    }

    /**
     * is_contact_button_page
     *
     * @return bool
     */
    public static function is_contact_button_page(): bool {
        if ( isset($_GET['page']) ) { // phpcs:ignore
            if ( 'contact-button-cb-settings' === $_GET['page'] ) { // phpcs:ignore
				return true;
			}
        }
        return false;
    }

    public function custom_menu_icon_css() {
		printf('<style>#toplevel_page_contact-button-cb-settings .dashicons-admin-generic:before{content: \'\';background-image: url(%s/admin/img/cb-icon.svg);background-repeat: no-repeat;background-position: center;}</style>', esc_attr(CONTACT_BUTTON_CB_URL));
    }
}
