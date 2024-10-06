<?php
/*
Plugin Name: Chat & Call Sticky Button
Description: Adds floating chat (WhatsApp) and Call Us buttons to your website.
Version: 2.0
Author: Faisal Khan
*/

// Enqueue styles and scripts
function contact_buttons_enqueue_styles() {
    wp_enqueue_style('contact-buttons-style', plugin_dir_url(__FILE__) . 'contact-buttons.css');
}
add_action('wp_enqueue_scripts', 'contact_buttons_enqueue_styles');

// Add buttons to the footer
function add_contact_buttons() {
    $whatsapp_link = get_option('contact_buttons_whatsapp', 'https://wa.me/yourwhatsappnumber');
    $phone_number = get_option('contact_buttons_phone', 'yourphonenumber');

    echo '<div class="contact-buttons">
            <a href="' . esc_url($whatsapp_link) . '" class="whatsapp-button">WhatsApp</a>
            <a href="tel:' . esc_attr($phone_number) . '" class="call-button">Call us</a>
          </div>';
}
add_action('wp_footer', 'add_contact_buttons');

// Create a settings page
function contact_buttons_create_menu() {
    add_menu_page(
        'Chat & Call Sticky Button',       
        'Chat & Call Sticky Button',       
        'manage_options',                  
        'chat-call-sticky-button',         
        'contact_buttons_settings_page',    
        'dashicons-phone',                 
        90                                 
    );
}
add_action('admin_menu', 'contact_buttons_create_menu');

function contact_buttons_settings_page() {
?>
    <div class="wrap">
        <h1>Chat & Call Sticky Buttons Settings</h1>
        <p>Please add your full WhatsApp link in the format <b>https://wa.me/number</b> and your phone number.</p>
        <?php settings_errors(); ?>
        <form method="post" action="options.php">
            <?php
                settings_fields('contact-buttons-settings-group');
                do_settings_sections('contact-buttons-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">WhatsApp Link</th>
                    <td>
                        <input type="text" name="contact_buttons_whatsapp" placeholder="https://wa.me/number" value="<?php echo esc_attr(get_option('contact_buttons_whatsapp')); ?>" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Phone Number</th>
                    <td>
                        <input type="text" name="contact_buttons_phone" placeholder="xxxxxxxxxx" value="<?php echo esc_attr(get_option('contact_buttons_phone')); ?>" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Validation function for WhatsApp link
function validate_whatsapp_link($input) {
    if (filter_var($input, FILTER_VALIDATE_URL) && strpos($input, 'https://wa.me/') === 0) {
        return esc_url_raw($input);
    } else {
        add_settings_error('contact_buttons_whatsapp', 'invalid_whatsapp_link', 'Please enter a valid WhatsApp link starting with https://wa.me/');
        return '';
    }
}

function contact_buttons_register_settings() {
    register_setting('contact-buttons-settings-group', 'contact_buttons_whatsapp', 'validate_whatsapp_link');
    register_setting('contact-buttons-settings-group', 'contact_buttons_phone');
}
add_action('admin_init', 'contact_buttons_register_settings');
?>
