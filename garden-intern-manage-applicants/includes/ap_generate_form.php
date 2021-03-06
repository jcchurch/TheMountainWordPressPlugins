<?php

namespace Mountain\Garden\Manage;

require('display_filter_menu.php');
require('display_table_of_applicants.php');
require('display_garden_update_form.php');
require('update_applicant.php');
require('pull_database.php');
require('pull_post_data.php');

/**
 * This function organizes the page.
 */
function ap_generate_form() {
/*
 *   Read mtn_application table were application data is stored
 *   Build table in the top panel where the use can then use a
 *   radio button and select button to display/update date in
 *   lower left/right panels.
 */

    $filterCriteria = pullFilterCriteria();
    $applications = pullRecords("mtn_application", $filterCriteria);
    $id = pullActiveRecordIdentifier();

    $columns = array( 
                    array( "tag" => "ap_id", "name" => "ID" )
                  , array( "tag" => "ap_firstname", "name" => "First Name")
                  , array( "tag" => "ap_lastname", "name" => "Last Name")
                  , array( "tag" => "ap_city", "name" => "City")
                  , array( "tag" => "ap_state", "name" => "State")
                  , array( "tag" => "ap_status", "name" => "Status")
                  , array( "tag" => "ap_session", "name" => "Session")
                  );

    if ($id >= 0) {
        $record = findRecordInApplications($applications, $id);
        displayGardenUpdateForm($record, $id, $columns, $staffComments);

        if (updateButtonClicked()) {
            $applications = pullRecords("mtn_application", $filterCriteria);
        }
    }

    displayFilterMenu($filterCriteria);
    displayTableOfApplicants($applications, $id, $columns);
}

/**
 * Indexes through the list of $applications and finds the
 * record which matches $id.
 * Critical: if the $id cannot be found in $applications,
 * the an assert exception is triggered.
 *
 * @param $applications a list of applications
 * @param $id an id of a record to be found within $applications
 * @return the record identified by $id.
 */
function findRecordInApplications($applications, $id) {
    $record = array();

    foreach ($applications as $aRecord) {
        if ($aRecord["ap_id"] == $id) {
            $record = $aRecord;
        }
    }

    assert(empty($record)==false, "ID was not found in list of applicants.");
    return $record;
}

?>
