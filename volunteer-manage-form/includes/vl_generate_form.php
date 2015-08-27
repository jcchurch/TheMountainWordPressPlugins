<?php

namespace Mountain\Volunteer\Manage;

require('display_filter_menu.php');
require('display_table_of_applicants.php');
require('display_volunteer_update_form.php');
require('update_applicant.php');
require('pull_database.php');
require('pull_post_data.php');

/**
 * This function organizes the page.
 */
function vl_generate_form() {
/*
 *   Read mtn_application table were application data is stored
 *   Build table in the top panel where the use can then use a
 *   radio button and select button to display/update date in
 *   lower left/right panels.
 */

    $filterCriteria = pullFilterCriteria();
    $applications = pullRecords("mtn_volunteer", $filterCriteria);
    $id = pullActiveRecordIdentifier();

    $columns = array( 
                    array( "tag" => "vl_id", "name" => "ID" )
                  , array( "tag" => "vl_firstname", "name" => "First Name")
                  , array( "tag" => "vl_lastname", "name" => "Last Name")
                  , array( "tag" => "vl_city", "name" => "City")
                  , array( "tag" => "vl_state", "name" => "State")
                  , array( "tag" => "vl_status", "name" => "Status")
                  , array( "tag" => "vl_volunteer_interest", "name" => "Interest")
                  );

    if ($id >= 0) {
        $record = findRecordInApplications($applications, $id);
        displayGardenUpdateForm($record, $id, $columns, $staffComments);

        if (updateButtonClicked()) {
            $applications = pullRecords("mtn_volunteer", $filterCriteria);
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
        if ($aRecord["vl_id"] == $id) {
            $record = $aRecord;
        }
    }

    assert(empty($record)==false, "ID was not found in list of applicants.");
    return $record;
}

?>
