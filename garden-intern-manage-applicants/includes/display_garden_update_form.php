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
              <td style="width: 250px">Comments </td>
              <td style="width: 100px">Author </td>
              <td style="width: 100px">Date <td>
            </tr>
            </table>
            </div>

            <div class="panelrightlines" style="overflow: auto;height: 320px; ">
                <table   cellpadding="0" cellspacing="0">
<?php

    if(!empty($applications[$selected_row]['ap_id'])) {
            $table_name = "mtn_meta_data";
            $sql = "Select * from $table_name where mm_object_id={$applications[$selected_row]['ap_id']} order by mm_insert_date DESC";
            $meta_data = $wpdb->get_results($sql,ARRAY_A);

            foreach ($meta_data as $key => $value) {
                echo  '<tr>' ;
                echo  '<td style="width: 230px">' .  $meta_data[$key]['mm_meta_data']. '</td>';
                echo  '<td style="width: 95px">' .  $meta_data[$key]['mm_meta_user']. '</td>';
                echo  '<td style="width: 95px">' .  $meta_data[$key]['mm_insert_date']. '</td>';
                echo  '</tr>' ;
            }
        }
?>

                </table>

            </div>
        </div>
        <br></br>
        <input type="submit" name="application_form" value="Update" ></input>

    </form>

    <?php
 /*
  * Check if Update (submit) button clicked
  * If true, add a entry into the mtn_meta_data if
  * 1. Status has been changed
  * 2. Comments have been added
  * If the status has been changed, update the status in the mtn_application table for the
  * appropriate row.
  * Note: the $application[$seleced_row]['ap_id'] is the primary key to the mtn-application table.
  */

    if (isset($_POST['application_form'])) {
        $update_status = FALSE;
        $update_staff_comments = FALSE;

        global $current_user;
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
        if (!empty($_POST['status'])) {

            $status = $_POST['status'];

            $table_name =  'mtn_application';
            $wpdb->update( $table_name, array( 'ap_status' => $status),array('ap_id'=>$applications[$selected_row]['ap_id']));

            $table_name =  'mtn_meta_data';
            $mm_data_id = 'Garden Internship';
            $mm_object_id = $applications[$selected_row]['ap_id'];
            $mm_meta_data = 'Auto Msg: Status changed from ' . $applications[$selected_row]['ap_status'] . ' to ' . $status;

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
        if (isset($_POST['staff_comments'])) {
            if(strlen(trim($_POST['staff_comments'])) > 0) {

                $table_name = 'mtn_meta_data';
                $mm_data_id = 'Garden Internship';
                $mm_object_id = $applications[$selected_row]['ap_id'];
                $mm_meta_data = $_POST['staff_comments'];

                $wpdb->insert($table_name, array(
                      'mm_meta_id'    => $mm_data_id
                    , 'mm_object_id'  => $mm_object_id
                    , 'mm_meta_user'  => $current_user_name
                    , 'mm_meta_data'  => $mm_meta_data
                ));

                $update_staff_comments = TRUE;
            }
        }

        if ($update_status or $update_staff_comments) {

            $update_msg = "";
            if ($update_status) {
                $update_msg = 'Status changed from: "' . $applications[$selected_row]['ap_status'] . '" ==> "' . $status . '"';
            }

            if ($update_staff_comments) {
                $update_msg .= '<br>Comments added: ' . $_POST['comments'];
            }
?>
        <div class="panelsuccess">
        <h3>Update Successful</h3>

        <h4>
        <?php echo $update_msg;?>
        </h4><br>
        <label>Click <span style="color:red">Select Applicant</span> to view updated data</label>
        </div>

<?php
        }

    } /* Application form submitted */
} /* end of function ap_generate_form ()*/

?>
