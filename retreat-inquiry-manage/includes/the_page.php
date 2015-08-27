<?php

namespace Mountain\Retreat\Manage;

require('display_filter_menu.php');
require('display_table_of_records.php');
require('display_update_form.php');
require('update_record.php');
require('pull_database.php');
require('pull_post_data.php');

/**
 * This function organizes the page.
 */
function thepage() {

    $status_column = "ri_status";
    $id_column = "ri_id";
    $table_name = "mtn_retreat_inquiry";

    $columns = array( 
                    array( "tag" => "ri_id", "name" => "ID" )
                  , array( "tag" => "ri_firstname", "name" => "First Name")
                  , array( "tag" => "ri_lastname", "name" => "Last Name")
                  , array( "tag" => "ri_city", "name" => "City")
                  , array( "tag" => "ri_state", "name" => "State")
                  , array( "tag" => "ri_status", "name" => "Status")
                  );

    $filters = array(
                    array( "label"  => "Filter by Status:"
                         , "name"   => "filterStatus"
                         , "column" => "ri_status")
                  , array( "label"  => "Filter by Last Name:"
                         , "name"   => "filterLastName"
                         , "column" => "ri_lastname")
                  );

    $filterCriteria = pullFilterCriteria($filters);
    $records = pullRecords($table_name, $filterCriteria);
    $id = pullActiveRecordIdentifier();

    if ($id >= 0) {
        $record = findRecord($records, $id, $id_column);
        $update_title = "Update Mountain Retreat Inquiry";
        displayUpdateForm($update_title, $record, $id, $columns, $table_name, $status_column, $id_column, "Retreat Inquiry");

        if (updateButtonClicked()) {
            $records = pullRecords($table_name, $filterCriteria);
        }
    }

    displayFilterMenu($table_name, $filters);
    displayTableOfRecords($records, $id, $columns, $id_column, "List of Inquiries");
}

/**
 * Indexes through the list of $records and finds the
 * record which matches $id.
 * Critical: if the $id cannot be found in $records,
 * the an assert exception is triggered.
 *
 * @param $records a list of records
 * @param $id an id of a record to be found within $records
 * @return the record identified by $id.
 */
function findRecord($records, $id, $id_column) {
    $record = array();

    foreach ($records as $aRecord) {
        if ($aRecord[$id_column] == $id) {
            $record = $aRecord;
        }
    }

    assert(empty($record)==false, "ID was not found in list of records.");
    return $record;
}

?>
