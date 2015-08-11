<?php
/*
Plugin Name: Retreat Inquiry Form
Plugin URI: No URI
Description: The plugin allows a form to be included in a blog or page to submit a Retreat Inquiry.
Version: 1.0
Author: Jay Kiskel (Edits by James Church)
Author URI: http://studio205.tv
*/

require('includes/ri_admin_screen.php');
require('includes/mtn_retreat_inquiry_create.php');
require('includes/ri_form.php');

/* Functions in this file:
  ri_admin_screen() : Creates an admin screen to set the Mountain staff emails to send / receive 
  ri_plugin_menu()  : Adds a stand alone Retreat Inquiry menu option 
  ri_create_table() : Checks if the database table wp_mtn_retreat_inquiry exists, if not creates table and version number in options table.
  mtn_retreat_inquiry_form() : Generates the Retreat Inquiry Submission form, captures/edits data, sends emails and writes row to database table
  ri_shortcode() : Generates shortcode for form
 
  Also see function.php for Mountain functions for get_options, send_mail and error trapping and reporting
  
*/

function ri_plugin_menu() {
    add_menu_page('Retreat Inquiry', 'Retreat Inquiry Form','manage_options','ri_applic_plugin','ri_admin_screen');
}

/* add Retreat Inquiry Menu as a separate menu option on the Admin page */
add_action('admin_menu','ri_plugin_menu');

register_activation_hook(__FILE__,'mtn_retreat_inquiry_create');

function ri_shortcode() {
    ob_start();
    ri_form(); 
    return ob_get_clean();
}
 
add_shortcode( 'Retreat_Submission_Form', 'ri_shortcode' );
