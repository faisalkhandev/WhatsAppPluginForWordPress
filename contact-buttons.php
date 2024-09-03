<?php
/*
Plugin Name: Contact Buttons
Description: Adds WhatsApp and Call Us buttons to your website.
Version: 1.0
Author: Faisal Khan
*/

// Enqueue styles and scripts
function contact_buttons_enqueue_styles() {
    wp_enqueue_style('contact-buttons-style', plugin_dir_url(__FILE__) . 'contact-buttons.css');
}
add_action('wp_enqueue_scripts', 'contact_buttons_enqueue_styles');

// Add buttons to the footer
function add_contact_buttons() {
    echo '<div class="contact-buttons">
            <a href="https://wa.me/yourwhatsappnumber" class="whatsapp-button">WhatsApp</a>
            <a href="tel:yourphonenumber" class="call-button">Call us</a>
          </div>';
}
add_action('wp_footer', 'add_contact_buttons');
