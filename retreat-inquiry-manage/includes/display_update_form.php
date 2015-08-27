<?php

namespace Mountain\Retreat\Manage;

require('update_record.php');

/*  Mountain Staff Update Form
 *   The labels of the form are displayed twice
 *   Initially when no id is selected, only the labels are displayed
 *   Once a id is selected the labels and data are then display
 *
 */
function displayUpdateForm($title, $record, $id, $columns, $table_name, $status_column, $id_column, $note) {

    /* If there is no active post, do nothing. */
    if (!isset($record)) {
        return;
    }

?>
            <br>
            <div class="updatepanels">
            <h2><?php echo $title; ?></h2>

<?php
       if (updateButtonClicked()) {
            $newStatus = pullNewStatus();

            updateRecord   ($id,
                            $record[$statuscolumn],
                            $newStatus,
                            $table_name,
                            $status_column,
                            $id_column,
                            $note
                            );
        }
?>

            <div class="panelleft">
            <h4>Information</h4>
            <form method="post" action="">

<?php

    echo "<ul>\n";
    foreach ($columns as $column) {
        echo "<li><label class='mtnlabelClass'>{$column['name']}</label> <label class='mtndisplayClass'>{$record[$column['tag']]}</label></li>\n";
    }

    $selectionOptions = array('Submitted', 'In Progress', 'Approved', 'On Hold', 'Withdrawn', 'Rejected', 'Deferred');
?>
            <li><label>New Status</label>
            <select class="mtnselect" name="status">
            <option value="">Select▾</option>
<?php
    foreach ($selectionOptions as $anOption) {
        if ($anOption != $record['ap_status']) {
            echo "<option value='$anOption'>$anOption</option>\n";
        }
    }
?>
            </select>
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
    $activeRecordData = pullMetaData($id);
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
