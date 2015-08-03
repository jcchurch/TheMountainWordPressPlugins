<?php

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
        <form method="post" action="">
            <br>
            <h2>Update Applicant for Mountain Positions</h2>
            <div class="panelleft">
            <h4>Applicant Information</h4>

<?php

    echo "<ul>\n";
    foreach ($columns as $column) {
        if ($column['tag'] != "ap_comments") {
            echo "<li><label class='mtnlabelClass'>{$column['name']}</label> <label class='mtndisplayClass'>{$anApplicant[$column['tag']]}</label></li>\n";
        }
    }

    $selectionOptions = array('Submitted', 'In Progress', 'Approved', 'On Hold', 'Withdrawn');
?>
            <li><label>New Status</label>
            <select class="mtnselect" name="status">
            <option value="">Select▾</option>
<?php
    foreach ($selectionOptions as $anOption) {
        echo "<option value='$anOption'>$anOption</option>\n";
    }
?>
            </select>
            </li>
            <li><label>Comments:</label>
                 <textarea class="mtntextAreaClass" name="staff_comments" ><?php echo sanitize_text_field($staffComments); ?></textarea>
            </li>
            </ul>
<?php
/*
 *  Create the form table to display comments
 */
?>
            </div>
            <div class="panelright">
            <table style="width: 500px" cellpadding="0" cellspacing="0">
            <tr>
              <td style="width: 250px">Comments</td>
              <td style="width: 100px">Author</td>
              <td style="width: 100px">Date</td>
            </tr>

<?php
    $activeRecordData = pullMetaData($anApplicant['ap_id']);
    foreach ($activeRecordData as $record) {
        echo  '<tr>';
        echo  "<td style='width: 230px'>{$record['mm_meta_data']}</td>";
        echo  "<td style='width: 95px'>{$record['mm_meta_user']}</td>";
        echo  "<td style='width: 95px'>{$record['mm_insert_date']}</td>";
        echo  '</tr>';
    }
?>

            </table>

            </div>
        </div>

        <input type="hidden" name="active" value="id<?php echo $id ?>"></p>
        <p><input type="submit" name="application_form" value="Update"></p>

    </form>
<?php
}
?>
