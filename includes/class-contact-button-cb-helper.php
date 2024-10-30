<?php

/**
 * CONTACT_BUTTON_CB_HELPER
 */
class CONTACT_BUTTON_CB_HELPER {


    public function __construct() {
        //
    }

    public function is_in_header() {
        $in_header = get_option('contact-button-cb-in-header');

        if ( 'header' === $in_header) {
			return true;
        }

        return false;
    }

    public static function is_active() {
        $status = get_option('contact-button-cb-verify-status');
        $id = get_option('contact-button-id');
        if ('success' === $status && $id ) {
            return true;
        }
        return false;
    }

    public static function is_error() {
        $status = get_option('contact-button-cb-verify-status');
        if ('error' === $status) {
            return true;
        }
        return false;
    }

    public static function get_error_log() {
        $log['id'] = get_option('contact-button-id');
        $log['wp_website'] = home_url('/');
        $log['body'] = get_option('contact-button-cb-verify-curl-body');
        return $log;
    }
}
