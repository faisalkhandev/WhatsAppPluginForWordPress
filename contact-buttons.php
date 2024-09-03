<?php
/*
Plugin Name: WhatsApp Sticky Button
Description: Adds floating WhatsApp and Call Us buttons to your website.
Version: 1.2
Author: Faisal khan
*/

// Enqueue styles and scripts
function contact_buttons_enqueue_styles() {
    wp_enqueue_style('contact-buttons-style', plugin_dir_url(__FILE__) . 'contact-buttons.css');
}
add_action('wp_enqueue_scripts', 'contact_buttons_enqueue_styles');

// Add buttons to the footer
function add_contact_buttons() {
    $whatsapp_number = get_option('contact_buttons_whatsapp', 'yourwhatsappnumber');
    $phone_number = get_option('contact_buttons_phone', 'yourphonenumber');

    echo '<div class="contact-buttons">
            <a href="https://wa.me/' . esc_attr($whatsapp_number) . '" class="whatsapp-button">WhatsApp</a>
            <a href="tel:' . esc_attr($phone_number) . '" class="call-button">Call us</a>
          </div>';
}
add_action('wp_footer', 'add_contact_buttons');

function contact_buttons_create_menu() {
    add_menu_page(
        'WhatsApp Sticky Button',   
        'WhatsApp Sticky Button',   
        'manage_options',     
        'whatsApp-sticky-button',   
        'contact_buttons_settings_page',
        'dashicons-whatsapp',          
        90                                  
    );
}
add_action('admin_menu', 'contact_buttons_create_menu');

function contact_buttons_settings_page() {
?>
    <div class="wrap">
        <h1>WhatsApp Sticky Buttons Settings</h1>
        <p>Please add your WhatsApp number and phone number but <b>Add country code with WhatsApp number</b></p>
        <form method="post" action="options.php">
            <?php
                settings_fields('contact-buttons-settings-group');
                do_settings_sections('contact-buttons-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                <th scope="row">WhatsApp Number</th>
                <td><input type="text" name="contact_buttons_whatsapp" placeholder="+44xxxxxxxxxx" value="<?php echo esc_attr(get_option('contact_buttons_whatsapp')); ?>" /></td>
                </tr>
                
                <tr valign="top">
                <th scope="row">Phone Number</th>
                <td><input type="text" name="contact_buttons_phone" placeholder="xxxxxxxxxx" value="<?php echo esc_attr(get_option('contact_buttons_phone')); ?>" /></td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

function contact_buttons_register_settings() {
    register_setting('contact-buttons-settings-group', 'contact_buttons_whatsapp');
    register_setting('contact-buttons-settings-group', 'contact_buttons_phone');
}
add_action('admin_init', 'contact_buttons_register_settings');
