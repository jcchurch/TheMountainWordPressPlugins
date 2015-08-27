<?php
/*
 *  Plugin Name: Retreat Inquiry Manage
 *  Plugin URI:
 *  Description: This provides a form via shortcode to manage retreat inquiries
 *  Author: James Church
 *  Version: 1.0
 *  Author URI: http://www.studio205.tv
 */

namespace Mountain\Retreat\Manage;

require('includes/the_page.php');

function theme_name_scripts() { 
    wp_enqueue_style('retreat', plugins_url('css/retreat.css', __FILE__ )); 
    wp_enqueue_style('scrollContent', plugins_url('css/scrollContent.css', __FILE__ )); 
} 

function ap_shortcode() {
    ob_start();
    thepage();
    return ob_get_clean();
}

add_action('wp_enqueue_scripts', __NAMESPACE__.'\\theme_name_scripts');
add_shortcode( 'retreat_inquiry_manage', __NAMESPACE__.'\\ap_shortcode' );

?>
