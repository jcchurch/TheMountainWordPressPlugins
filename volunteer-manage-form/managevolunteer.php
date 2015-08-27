<?php
/*
 *  Plugin Name: Mountain Manage Volunteer Application
 *  Plugin URI:
 *  Description: This plugin creates a form to manage volunteer application data
 *  Author: Jay Kiskel (Based on work by James Church)
 *  Version: 1.0
 *  Author URI: 
 */

namespace Mountain\Volunteer\Manage;

require('includes/vl_generate_form.php');

function theme_name_scripts() { 
    wp_enqueue_style('volunteer', plugins_url('css/volunteer.css', __FILE__ )); 
    wp_enqueue_style('scrollContent', plugins_url('css/scrollContent.css', __FILE__ )); 
} 

function vl_manage_shortcode() {
    ob_start();
    vl_generate_form();
    return ob_get_clean();
}

add_action('wp_enqueue_scripts', __NAMESPACE__.'\\theme_name_scripts');
add_shortcode( 'vol_application_form', __NAMESPACE__.'\\vl_manage_shortcode' );

?>
