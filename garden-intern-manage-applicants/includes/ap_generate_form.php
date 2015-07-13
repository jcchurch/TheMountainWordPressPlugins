<?php

require('display_table_of_applicants.php');
require('display_garden_update_form.php');
require('update_applicant.php');

function ap_generate_form() {
    global $wpdb;

/*
 *   Read mtn_application table were application data is stored
 *   Build table in the top panel where the use can then use a
 *   radio button and select button to display/update date in
 *   lower left/right panels.
 */

    $table_name = "mtn_application";
    $sql = 'Select * from ' . $table_name;
    $applications = $wpdb->get_results($sql,ARRAY_A);

    $columns = array( 
                    array( "tag" => "ap_id", "name" => "ID" )
                  , array( "tag" => "ap_firstname", "name" => "First Name")
                  , array( "tag" => "ap_lastname", "name" => "Last Name")
                  , array( "tag" => "ap_address1", "name" => "Address 1")
                  , array( "tag" => "ap_address2", "name" => "Address 2")
                  , array( "tag" => "ap_city", "name" => "City")
                  , array( "tag" => "ap_state", "name" => "State")
                  , array( "tag" => "ap_comments", "name" => "Comments")
                  , array( "tag" => "ap_status", "name" => "Status")
                  );

    displayGardenUpdateForm($applications, $columns);
    updateApplicant();
    displayTableOfApplicants($applications, $columns);
}

?>
