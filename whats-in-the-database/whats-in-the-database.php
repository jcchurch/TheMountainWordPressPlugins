<?php
/*
 *  Plugin Name: What's in the database?
 *  Plugin URI:
 *  Description: This plugin looks at a database table.
 *  Author: James Church
 *  Version: 1.0
 *  Author URI: http://www.studio205.tv
 */

require('includes/inspect_database.php');

function startPlugin() {
    ob_start();
    inspectDatabase();
    return ob_get_clean();
}

add_action('wp_enqueue_scripts', 'theme_name_scripts');
add_shortcode( 'whats_in_the_database', 'startPlugin' );

?>
