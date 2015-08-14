<?php

function mtn_retreat_inquiry_create() {
    /* 1. Create custom table mtn_retreat_inquiry that will hold retreat inquire submissions                    */
    /* 2. Note: this plugin uses the custom table mtn_meta_data that will hold comments made on submissions     */
    /*    auto generated comments when a inquiry status is changed                                              */  
    global $wpdb;

    $table_name = "mtn_retreat_inquiry";

    // will return NULL if there isn't one
    if ( $wpdb->get_var('SHOW TABLES LIKE ' . $table_name) != $table_name ) {
        $sql = 'CREATE TABLE ' . $table_name . '(
                ri_id INTEGER(10) UNSIGNED AUTO_INCREMENT,
                ri_firstname VARCHAR (30), 
                ri_lastname VARCHAR (30),           
                ri_address1 VARCHAR (35),
                ri_address2 VARCHAR (35),
                ri_city VARCHAR (35),
                ri_state VARCHAR (2),
                ri_zip VARCHAR (5),         
                ri_mobile VARCHAR (10),
                ri_email VARCHAR (35),          
                ri_desired_dates VARCHAR (35),          
                ri_retreat_name VARCHAR (35),
                ri_retreat_org VARCHAR (35),                        
                ri_retreat_org_url VARCHAR (35),                        
                ri_heard_about VARCHAR (35),
                ri_comments VARCHAR (255),
                ri_type VARCHAR (30),
                ri_status VARCHAR (20),
                ri_submit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY  (ri_id) )';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } /* Show tables like */
} /* mtn_retreat_inquiry_create */

?>
