<?php
/*
Plugin Name: Chat & Call Sticky Button
Description: Adds floating chat (WhatsApp) and Call Us buttons to your website.
Version: 2.0
Author: Faisal Khan
License: GPLv2 or later
Text Domain: chat-call-sticky-button
Tested up to: 6.6.2  // Ensure this is the current WordPress version
*/

// Unique prefix for functions
function ccsb_enqueue_styles() {
    wp_enqueue_style('ccsb-style', plugin_dir_url(__FILE__) . 'contact-buttons.css');
}
add_action('wp_enqueue_scripts', 'ccsb_enqueue_styles');

// Add buttons to the footer
function ccsb_add_contact_buttons() {
    $whatsapp_link = get_option('ccsb_whatsapp', 'https://wa.me/yourwhatsappnumber');
    $phone_number = get_option('ccsb_phone', 'yourphonenumber');

    echo '<div class="contact-buttons">
            <a href="' . esc_url($whatsapp_link) . '" class="whatsapp-button">WhatsApp</a>
            <a href="tel:' . esc_attr($phone_number) . '" class="call-button">Call us</a>
          </div>';
}
add_action('wp_footer', 'ccsb_add_contact_buttons');

// Create a settings page
function ccsb_create_menu() {
    add_menu_page(
        'Chat & Call Sticky Button',       
        'Chat & Call Sticky Button',       
        'manage_options',                  
        'chat-call-sticky-button',         
        'ccsb_settings_page',    
        'dashicons-phone',                 
        90                                
    );
}
add_action('admin_menu', 'ccsb_create_menu');

function ccsb_settings_page() {
?>
    <div class="wrap">
        <h1>Chat & Call Sticky Buttons Settings</h1>
        <p>Please add your full WhatsApp link in the format <b>https://wa.me/number</b> and your phone number.</p>
        <?php settings_errors(); ?>
        <form method="post" action="options.php">
            <?php
                settings_fields('ccsb-settings-group');
                do_settings_sections('ccsb-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">WhatsApp Link</th>
                    <td>
                        <input type="text" name="ccsb_whatsapp" placeholder="https://wa.me/number" value="<?php echo esc_attr(get_option('ccsb_whatsapp')); ?>" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Phone Number</th>
                    <td>
                        <input type="text" name="ccsb_phone" placeholder="xxxxxxxxxx" value="<?php echo esc_attr(get_option('ccsb_phone')); ?>" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Validation function for WhatsApp link
function ccsb_validate_whatsapp_link($input) {
    if (filter_var($input, FILTER_VALIDATE_URL) && strpos($input, 'https://wa.me/') === 0) {
        return esc_url_raw($input);
    } else {
        add_settings_error('ccsb_whatsapp', 'invalid_whatsapp_link', 'Please enter a valid WhatsApp link starting with https://wa.me/');
        return '';
    }
}

function ccsb_register_settings() {
    register_setting('ccsb-settings-group', 'ccsb_whatsapp', 'ccsb_validate_whatsapp_link');
    register_setting('ccsb-settings-group', 'ccsb_phone');
}
add_action('admin_init', 'ccsb_register_settings');
?>
