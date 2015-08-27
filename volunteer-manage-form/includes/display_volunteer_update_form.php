<?php

namespace Mountain\Volunteer\Manage;

/*  Mountain Staff Update Form
 *   The labels of the form are displayed twice
 *   Initially when no id is selected, only the labels are displayed
 *   Once a id is selected the labels and data are then display
 *
 */
function displayGardenUpdateForm($anApplicant, $id, $columns, $staffComments) {

    /* If there is no active post, do nothing. */
    if (!isset($anApplicant)) {
        return;
    }

?>
            <br>
            <div class="updatepanels">
            <h2>Update Applicant for Volunteer Positions</h2>

<?php
       if (updateButtonClicked()) {
            $staffComments = pullStaffComments();
            $newStatus = pullNewStatus();

            updateApplicant($anApplicant['vl_id'],
                            $anApplicant['vl_status'],
                            $newStatus,
                            $staffComments);
        }
?>

            <div class="panelleft">
            <h4>Applicant Information</h4>
            <form method="post" action="">

<?php

    echo "<ul>\n";
    foreach ($columns as $column) {
        if ($column['tag'] != "vl_comments") {
            echo "<li><label class='mtnlabelClass'>{$column['name']}</label> <label class='mtndisplayClass'>{$anApplicant[$column['tag']]}</label></li>\n";
        }
    }

    $selectionOptions = array('Submitted', 'In Progress', 'Approved', 'On Hold', 'Withdrawn', 'Rejected', 'Deferred');
?>
            <li><label>New Status</label>
            <select class="mtnselect" name="status">
            <option value="">Select▾</option>
<?php
    foreach ($selectionOptions as $anOption) {
        if ($anOption != $anApplicant['vl_status']) {
            echo "<option value='$anOption'>$anOption</option>\n";
        }
    }
?>
            </select>
            </li>
            <li><label>Comments:</label>
                 <textarea class="mtntextAreaClass" name="staff_comments" ><?php echo sanitize_text_field($staffComments); ?></textarea>
            </li>
            </ul>
            <input type="hidden" name="active" value="id<?php echo $id ?>">
            <p><input type="submit" name="application_form" value="Update"></p>
            </form>
<?php
/*
 *  Create the form table to display comments
 */
?>
            </div>
            <div class="panelright">
            <table class="scrollTable">
            <thead class="fixedHeader">
            <tr>
              <th>Comments</th>
              <th>Author</th>
              <th>Date</th>
            </tr>
            </thead>
            <tbody class="scrollContent">

<?php
    $activeRecordData = pullMetaData($anApplicant['vl_id']);
    foreach ($activeRecordData as $record) {
        echo  "<tr>\n";
        echo  "<td>{$record['mm_meta_data']}</td>\n";
        echo  "<td>{$record['mm_meta_user']}</td>\n";
        echo  "<td>{$record['mm_insert_date']}</td>\n";
        echo  "</tr>\n";
    }
?>

            </tbody>
            </table>

            </div>
            </div>
<?php
}
?>
