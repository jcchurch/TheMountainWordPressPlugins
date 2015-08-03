<?php
 /*
  * Check if Update (submit) button clicked
  * If true, add a entry into the mtn_meta_data if
  * 1. Status has been changed
  * 2. Comments have been added
  * If the status has been changed, update the status in the mtn_application
  * table for this $recordId
  * Note: the $recordId is the primary key to the mtn-application table.
  */
function updateApplicant($recordId, $oldStatus, $newStatus, $staffComments) {
    global $current_user;
    global $wpdb;

    $update_status = FALSE;
    $update_staff_comments = FALSE;

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
    if (strlen($newStatus) > 0) {
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

        $update_status = TRUE;
    }

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

        $update_staff_comments = TRUE;
    }

    if ($update_status or $update_staff_comments) {

        $update_msg = "";
        if ($update_status) {
            $update_msg = "<p>Status changed from: $oldStatus ==> $newStatus</p>";
        }

        if ($update_staff_comments) {
            $update_msg .= "<p>Comments added: $staffComments</p>";
        }
?>
        <div class="panelsuccess">
        <h3>Update Successful</h3>

        <h4>
        <?php echo $update_msg;?>
        </h4>
        <p><label>Click <span style="color:red">Select Applicant</span> to view updated data</label></p>
        </div>

<?php
    }
}

?>
