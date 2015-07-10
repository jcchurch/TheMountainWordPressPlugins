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

function ap_shortcode() {
    ob_start();
    ap_generate_form();
    return ob_get_clean();
}

add_shortcode( 'application_form', 'ap_shortcode' );

?>
