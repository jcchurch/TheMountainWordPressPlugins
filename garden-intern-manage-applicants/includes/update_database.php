<?php

namespace Mountain\Garden\Manage;

/**
 * Updates an applicant's status. If the new status is the same
 * as the old status, no change is made.
 *
 * @param $recordId id of applicant who needs to be updated
 * @param $oldStatus old status of the applicant
 * @param $newStatus new status of the applicant
 * @return true if a change was made, false otherwise.
 */
function updateStatus($recordId, $oldStatus, $newStatus) {
    global $current_user;
    global $wpdb;

    get_currentuserinfo();
    $current_user_name = $current_user->user_login;
    $current_user_firstname = $current_user->user_firstname;
    $current_user_lastname = $current_user->user_lastname;
    $current_user_display_name = $current_user->display_name;

    /*
     *  Determine if new status selected from dropdown list
     *  Update to new status and add comment to mtn_meta_data that
     *  status has changed
     */
    if (strlen($newStatus) > 0 && $oldStatus != $newStatus) {
        $table_name =  'mtn_application';
        $wpdb->update($table_name, array('ap_status' => $newStatus),array('ap_id'=>$recordId));

        $table_name =  'mtn_meta_data';
        $mm_data_id = 'Garden Internship';
        $mm_object_id = $recordId;
        $mm_meta_data = "Auto Msg: Status changed from $oldStatus to $newStatus.";

        $wpdb->insert($table_name, array(
            'mm_meta_id'    => $mm_data_id,
            'mm_object_id'  => $mm_object_id,
            'mm_meta_user'  => $current_user_name,
            'mm_meta_data'  => $mm_meta_data
        ));

        return true;
    }

    return false;
}

/**
 * Updates an applicant's staff comments in the database.
 * If $staffComments is an empty string, no change to the database is made.
 *
 * @param $staffComments comments provided by the staff
 * @return true if a change was made, false otherwise
 */
function updateStaffComments($recordId, $staffComments) {
    global $current_user;
    global $wpdb;

    get_currentuserinfo();
    $current_user_name = $current_user->user_login;
    $current_user_firstname = $current_user->user_firstname;
    $current_user_lastname = $current_user->user_lastname;
    $current_user_display_name = $current_user->display_name;

    /*
     *  Determine if user comments have been added.
     *  Add user comments to mtn_meta_data
     */
    if(strlen($staffComments) > 0) {
        $table_name = 'mtn_meta_data';
        $mm_data_id = 'Garden Internship';
        $mm_object_id = $recordId;
        $mm_meta_data = $staffComments;

        $wpdb->insert($table_name, array(
              'mm_meta_id'    => $mm_data_id
            , 'mm_object_id'  => $mm_object_id
            , 'mm_meta_user'  => $current_user_name
            , 'mm_meta_data'  => $mm_meta_data
        ));

        return true;
    }

    return false;
}

?>
