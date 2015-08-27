<?php

namespace Mountain\Volunteer\Manage;

require('update_database.php');

/**
 * Updates an applicant's status and staff comments.
 *
 * This function performs 0, 1, or 2 database updates.
 * - If $newStatus is not an empty string, the database updates
 * - If $staffComments is not an empty string, the database updates
 *
 * @param $recordId id of applicant who needs to be updated
 * @param $oldStatus old status of the applicant
 * @param $newStatus new status of the applicant
 * @param $staffComments comments provided by the staff
 */
function updateApplicant($recordId, $oldStatus, $newStatus, $staffComments) {

    $update_status = updateStatus($recordId, $oldStatus, $newStatus);
    $update_staff_comments = updateStaffComments($recordId, $staffComments);

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
        <p><label>Click <span style="color:red">Select Volunteer</span> to view updated data</label></p>
        </div>

<?php
    }
}

?>
