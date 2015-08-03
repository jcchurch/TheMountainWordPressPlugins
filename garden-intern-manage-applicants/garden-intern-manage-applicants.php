<?php
/*
 *  Plugin Name: Garden Intern Manage Application
 *  Plugin URI:
 *  Description: This provides a form via shortcode to manage applications (2015-07-09)
 *  Author: Jay Kiskel (Edits by James Church)
 *  Version: 1.0
 *  Author URI: http://www.studio205.tv
 */

require('includes/ap_generate_form.php');

function theme_name_scripts() { 
    wp_enqueue_style('garden', plugins_url('css/garden.css', __FILE__ )); 
    wp_enqueue_style('scrollContent', plugins_url('css/scrollContent.css', __FILE__ )); 
} 
     
function ap_shortcode() {
    ob_start();
    ap_generate_form();
    return ob_get_clean();
}

add_action('wp_enqueue_scripts', 'theme_name_scripts');
add_shortcode( 'application_form', 'ap_shortcode' );

?>
