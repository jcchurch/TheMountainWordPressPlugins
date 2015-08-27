<?php

namespace Mountain\Retreat\Manage;

require('update_database.php');

/**
 * Updates a records's status.
 *
 * This function performs 0, 1, or 2 database updates.
 * - If $newStatus is not an empty string, the database updates
 *
 * @param $recordId id of applicant who needs to be updated
 * @param $oldStatus old status of the applicant
 * @param $newStatus new status of the applicant
 * @param $table_name Name of the table to update
 * @param $status_column name of status column
 * @param $id_column name of id column
 * @param $note Note to be put in meta data table
 */
function updateRecord($recordId, $oldStatus, $newStatus, $table_name, $status_column, $id_column, $note) {

    $update_status = updateStatus($recordId, $oldStatus, $newStatus, $table_name, $status_column, $id_column, $note);

    if ($update_status) {

        $update_msg = "";
        if ($update_status) {
            $update_msg = "<p>Status changed from: $oldStatus ==> $newStatus</p>";
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
