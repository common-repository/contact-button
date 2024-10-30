<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://contactbutton.com
 * @since      1.0.0
 */
?>

<div class="wrap">
    <div class="contact-button-header">
        <img src="<?php echo esc_attr(CONTACT_BUTTON_CB_URL . 'admin/img/cb-hero.svg'); ?>" alt="<?php esc_attr_e('Contact Button', 'contact-button-cb'); ?>" class="contact-button-settings-logo"><span>
                            <?php
								esc_html_e(
                                    'Powering customer convenience, with the click of a button',
                                    'contact-button-cb'
								);
								?>
        </span>
    </div>
    <div class="contact-button-content">
        <!-- Put an empty <h2></h2> to display notices under it --> 
        <h2></h2>
        <form action="" method="post">
            <div class="contact-button-section-1">
                <p><a target="_blank" href="https://contactbutton.com"><?php esc_html_e('Please visit contactbutton.com to create an account', 'contact-button-cb'); ?></a></p>
            </div>
            <?php
            if ( ! empty($contact_button_code)) {
				printf('<p class="contact-button-is-active">%s</p>', esc_html__('Congratulations! Contact Button is now installed on your site.', 'contact-button-cb')); }
			?>
            <div class="contact-button-section-2">
                <p>
                    <span>
                        <?php esc_html_e('To install your Contact Button on your site, please do the following:', 'contact-button-cb'); ?>
                        <br><br>
                        <?php esc_html_e('Step 1 - Log in to', 'contact-button-cb'); ?> <a target="_blank" href="https://contactbutton.com">ContactButton.com</a>. <?php esc_html_e('(If you don\'t have an account, please register first.)', 'contact-button-cb'); ?>
                        <br>
                        <?php esc_html_e('Step 2 - Make sure you have at least one Widget App and one Contact Button active in your account', 'contact-button-cb'); ?>
                        <br>
                        <?php esc_html_e('Step 3 - Open the Settings page by using the side menu', 'contact-button-cb'); ?>
                        <br>
                        <?php esc_html_e('Step 4 - Make sure you\'re on the "Test & Install" tab', 'contact-button-cb'); ?>
                        <br>
                        <?php esc_html_e('Step 5 - Click the "Install" button of the Contact Button you want to activate', 'contact-button-cb'); ?>
                        <br>
                        <?php esc_html_e('Step 6 - Click on "Install Our Wordpress Plugin"', 'contact-button-cb'); ?>
                        <br>
                        <?php esc_html_e('Step 7 - Copy the ID associated with your button', 'contact-button-cb'); //phpcs:ignore ?>
                        <br>
                        <?php esc_html_e('Step 8 - Paste copied text into the white box below and click the Save and Verify button', 'contact-button-cb'); ?>
                        <br><br>
                        <?php esc_html_e('Once activated your button should immediately start showing up on your website the next time you refresh the page you\'re on.', 'contact-button-cb'); ?>
                        <br><br>
                        <?php esc_html_e('If your Contact Button doesn\'t show up after following these steps, please email', 'contact-button-cb'); ?> 
                        <?php if ( $this->helper::is_error()) : ?>
                            <a href="mailto:support@contactbutton.com?subject=WordPress button not working&body=Log - <?php echo esc_html(wp_json_encode($this->helper::get_error_log(), JSON_FORCE_OBJECT)); ?>">support@contactbutton.com</a>
                        <?php else : ?>
                            <a href="mailto:support@contactbutton.com?subject=WordPress button not working">support@contactbutton.com</a>
                        <?php endif; ?>
                        <?php esc_html_e('for assistance.', 'contact-button-cb'); ?>
                    </span>
                </p>
            </div>
            <div class="contact-button-section-3">
                <label for="contact-button-id">Contact Button ID</label>
                <input type="text" value="<?php echo esc_html($contact_button_id); ?>" id="contact-button-id" name="contact-button-id" placeholder="Paste Contact Button ID">
                <input id="load-contact-button-code-in-header" type="checkbox" name="load-contact-button-code-in-header" value="true" <?php echo ( $in_header ) ? 'checked' : ''; ?> >
                <label for="load-contact-button-code-in-header"><?php esc_html_e('Show Contact Button on your website', 'contact-button-cb'); ?></label>
                <?php wp_nonce_field('contact-button-save', 'nonce-contact-button-save'); ?>
            </div>
            <div class="contact-button-section-4">
                <input type="submit" value="<?php esc_html_e('Save and Verify', 'contact-button-cb'); ?>">
            </div>
        </form>
    </div>
</div>
