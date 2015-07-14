<?php

require('display_table_of_applicants.php');
require('display_garden_update_form.php');
require('update_applicant.php');
require('pull_database.php');
require('pull_post_data.php');

function ap_generate_form() {
/*
 *   Read mtn_application table were application data is stored
 *   Build table in the top panel where the use can then use a
 *   radio button and select button to display/update date in
 *   lower left/right panels.
 */

    $applications = pullApplicants();
    $row = pullActiveRecord();
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

    if ($row >= 0 && $row < count($applications)) {
        displayGardenUpdateForm($applications[$row], $row, $columns, $staffComments);

        if (updateButtonClicked()) {
            $staffComments = pullStaffComments();
            $newStatus = pullNewStatus();

            updateApplicant($applications[$row]['ap_id'],
                            $applications[$row]['ap_status'],
                            $newStatus,
                            $staffComments);
            $applications = pullApplicants();
        }
    }

    displayTableOfApplicants($applications, $row, $columns);
}

?>
