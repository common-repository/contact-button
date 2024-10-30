<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://contactbutton.com
 * @since      1.0.0
 *
 */

/**
 * The public-facing functionality of the plugin.
 *
 */
class CONTACT_BUTTON_CB_Public {

    /**
     * helper
     *
     * @var mixed
    */
    public $helper;

	/**
	 * Initialize the class and set its properties.
	 *
	 */
	public function __construct( $helper ) {

		$this->helper = $helper;
	}


    public function print_script() {
        $id = get_option('contact-button-id');
        if ($this->helper::is_active() && $this->helper->is_in_header()) {
            wp_enqueue_script( CONTACT_BUTTON_CB_DOMAIN, sprintf('//app.contactbutton.com/script/%s', esc_html($id)), array(), CONTACT_BUTTON_CB_VERSION, array( 'strategy' => 'async' ));
        }
    }
}
