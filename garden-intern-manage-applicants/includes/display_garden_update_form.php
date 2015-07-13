<?php

/*  Mountain Staff Update Form
 *   The labels of the form are displayed twice
 *   Initially when no row is selected, only the labels are displayed
 *   Once a row is selected the labels and data are then display
 *
 */
function displayGardenUpdateForm($applications, $columns) {
    global $wpdb;

    /* If there is no active post, do nothing. */
    if (!isset($_POST['active'])) {
        return;
    }

    $selected_row = str_replace("row", "", $_POST['active']);

?>
        <form method="post" action="" >
            <br>
            <h2>Update Applications for Mountain Positions</h2>
            <div class="panelleft">
            <h4>Applicant Information</h4>

<?php

    echo "<ul>\n";
    foreach ($columns as $column) {
        if ($column['tag'] != "ap_comments") {
            if (is_numeric($selected_row) && $selected_row >= 0) {
                echo "<li><label class='mtnlabelClass'>{$column['name']}</label> <label class='mtndisplayClass'>{$applications[$selected_row][$column['tag']]}</label></li>\n";
            }
            else {
                echo "<li><label>{$column['name']}</label></li>\n";
            }
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
                 <textarea class="mtntextAreaClass" name="staff_comments" ><?php
                     if(isset ($_POST['staff_comments'])) {
                         echo sanitize_text_field($_POST['staff_comments']);
                     }
                 ?></textarea>
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

    if(!empty($applications[$selected_row]['ap_id'])) {
            $table_name = "mtn_meta_data";
            $sql = "Select * from $table_name where mm_object_id={$applications[$selected_row]['ap_id']} order by mm_insert_date DESC";
            $meta_data = $wpdb->get_results($sql,ARRAY_A);

            foreach ($meta_data as $key => $value) {
                echo  '<tr>';
                echo  "<td style='width: 230px'>{$meta_data[$key]['mm_meta_data']}</td>";
                echo  "<td style='width: 95px'>{$meta_data[$key]['mm_meta_user']}</td>";
                echo  "<td style='width: 95px'>{$meta_data[$key]['mm_insert_date']}</td>";
                echo  '</tr>';
            }
        }
?>

            </table>

            </div>
        </div>
        
        <p><input type="submit" name="application_form" value="Update"></p>

    </form>
<?
}
?>
