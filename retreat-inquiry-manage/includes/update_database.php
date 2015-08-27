<?php

namespace Mountain\Retreat\Manage;

/**
 * Updates an applicant's status. If the new status is the same
 * as the old status, no change is made.
 *
 * @param $recordId id of applicant who needs to be updated
 * @param $oldStatus old status of the applicant
 * @param $newStatus new status of the applicant
 * @param $table_name name of the table to update
 * @param $column name of the column within $table to update
 * @param $idcolumn name of the id column within $table to update
 * @param $mm_data_id Lable for this change
 * @return true if a change was made, false otherwise.
 */
function updateStatus($recordId, $oldStatus, $newStatus, $table_name, $column, $idcolumn, $mm_data_id) {
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
        $wpdb->update($table_name, array($column => $newStatus), array($idcolumn=>$recordId));

        $mm_object_id = $recordId;
        $mm_meta_data = "Auto Msg: Status changed from $oldStatus to $newStatus.";

        $wpdb->insert('mtn_meta_data', array(
            'mm_meta_id'    => $mm_data_id,
            'mm_object_id'  => $mm_object_id,
            'mm_meta_user'  => $current_user_name,
            'mm_meta_data'  => $mm_meta_data
        ));

        return true;
    }

    return false;
}

?>
