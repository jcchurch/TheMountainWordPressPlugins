<?php

function ap_generate_form() {
    global $wpdb;

/*
 *   Read mtn_application table were application data is stored
 *   Build table in the top panel where the use can then use a
 *   radio button and select button to display/update date in
 *   lower left/right panels.
 */

    $table_name = "mtn_application";
    $sql = 'Select * from ' . $table_name;
    $applications = $wpdb->get_results($sql,ARRAY_A);

    ?>
    <form method="post" action="" name="applicationlist">
        <h2>List of Applications for Mountain Positions</h2>
        <Table style="border-style: solid">
        <tr>
            <td>Select</td>
            <td>ID</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Address 1</td>
            <td>City</td>
            <td>State</td>
            <td>Comments</td>
            <td>Status</td>
        </tr>
        <?php
/* Loop through result set from database query and display rows of data */

        foreach ($applications as $key => $value) {
                echo  '<tr>' ;

/* Tricky logic to set radio button. The table is built on each loop of the foreach loop.

   Place the Key of the recordset in the value field.  The Key value will be
   used to determine which row was select and which row should be updated.


   Need to determine in each loop how to display the table column of the checked radio button
   1. If no radio button selected, echo standard table column with no checked button
   2. If a radio button has been check (active not empty), then set column with a checked radio button
   3. Once a radio button has been selected, all the other rows not equal to the check radio button
      should be diplayed as a standard unchecked radio button

*/

    if($_SERVER['REQUEST_METHOD'] == "POST" && $key == $_POST["active"]) {
        echo '<td> <input type="radio" name="active" value="'. $key . '" checked> </td>';
    }
    else {
        echo '<td> <input type="radio" name="active" value="'. $key . '"> </td>';
    }

    echo  '<td>' . $applications[$key]['ap_id']. '</td>';
    echo  '<td>' . $applications[$key]['ap_firstname'] . '</td>';
    echo  '<td>' . $applications[$key]['ap_lastname'] . '</td>';
    echo  '<td>' . $applications[$key]['ap_address1'] . '</td>';
    echo  '<td>' . $applications[$key]['ap_city'] . '</td>';
    echo  '<td>' . $applications[$key]['ap_state']. '</td>';
    echo  '<td>' . $applications[$key]['ap_comments'] . '</td>';
    echo  '<td>' . $applications[$key]['ap_status'] . '</td>';

 } /* foreach loop */
        ?>
        </table>
        <br>
        <input type="submit" name="application_list" value="Select Applicant">
        </form>
        <br>

<?php

/* Set error message "No rows selected" as appropriate */

if (!empty($_POST['application_list'])) {
    if(empty($_POST['active'])) {
        echo '<font color="red">No row selected. Try again.</font>';
    }
    else {
        echo "<font> </font>";
    }
}
/*  Mountain Staff Update Form
*   The labels of the form are displayed twice
*   Initially when no row is selected, only the labels are displayed
*   Once a row is selected the labels and data are then display
*
 */
?>
        <form method="post" action="" >
            <br>
            <h2>Update Applications for Mountain Positions</h2>
            <div class="panelleft">
            <h4>Applicant Information</h4>

            <?php
            $selected_row = $_POST['active'];

/*          If a row is not selected, send labels  without data.
 *          if a row is selected, send labels with data. This will
 *          ensure updated data is re-displayed.
 *
 */

/*          if(empty(isset($_POST["active"])))  this logic fails on plugin activation*/

            if (empty($selected_row)) {
                    echo '<label> First Name: </label>';
                    echo '<br><label> Last Name   </label>';
                    echo '<br><label> Address 1   </label>';
                    echo '<br><label> Address 2   </label>';
                    echo '<br><label> City        </label>';
                    echo '<br><label> State       </label>';
                    echo '<br><label> Zip         </label>';
                    echo '<br><label> Comments    </label>';
                    echo '<br><label> Apply Date  </label>';
                    echo '<br> <br>';
                    echo '<label> Current Status  </lablel>';
                    echo '<br> <br>';
                    echo '<label> New Status  </lablel>';
             }
             else {

                    echo '<label class="mtnlabelClass"> First Name</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_firstname'] . '</label>';

                    echo '<br><label  class="mtnlabelClass">Last Name</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_lastname'] . '</label>';

                    echo '<br><label  class="mtnlabelClass">Address 1</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_address1'] . '</label>';

                    echo '<br><label  class="mtnlabelClass">Address 1</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_address1'] . '</label>';

                    echo '<br><label class="mtnlabelClass">City</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_city'] . '</label>';

                    echo '<br><label  class="mtnlabelClass">State</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_state'] . '</label>';

                    echo '<br><label  class="mtnlabelClass">Zip</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_zip'] . '</label>';

                    echo '<br><label class="mtnlabelClass" >Apply Date</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_apply_date'] . '</label>';

                    echo '<br><label class="mtnlabelClass" >Comments </label>';
                    echo  '<label class="mtntextareadisplayClass">' . $applications[$selected_row]['ap_comments'] . '</label>';

                    echo '<br><label class="mtnlabelClass">Status</label>';
                    echo  '<label class="mtndisplayClass" >' . $applications[$selected_row]['ap_status'] . '</label>';

                    echo '<br>';

                    $curr_status = $applications[$selected_row]['ap_status'];
                    (($curr_status == 'Submitted') ? ($submt = 'selected') : ($submt =''));
                    (($curr_status == 'In Progress') ? ($inprog = 'selected') : ($inprog =''));
                    (($curr_status == 'Approved') ? ($approv = 'selected') : ($approv =''));
                    (($curr_status == 'On Hold') ? ($onhold = 'selected') : ($onhold =''));
                    (($curr_status == 'Withdrawn') ? ($withdrw = 'selected') : ($withdrw =''));
                    ?>
                    <label> New Status  </lablel>
                    <select class="mtnselect" name="status">
                    <option value="">Select▾</option>
                    <?php
                    If($curr_status != 'Submitted') {echo '<option value="Submitted">Submitted</option>';}
                    If($curr_status != 'In Progress') {echo '<option value="In Progress">In Progress</option>';}
                    If($curr_status != 'Approved') {echo '<option value="Approved">Approved</option>';}
                    If($curr_status != 'On Hold') {echo '<option value="On Hold">On Hold</option>';}
                    If($curr_status != 'Withdrawn') {echo '<option value="Withdrawn">Withdrawn</option>';}
                    ?>
                    </select>
                    <?php

                }
                ?>
                        <br>
                        <span class="labelClass"> Comments: </span>
                        <textarea class="mtntextAreaClass" name="staff_comments" >
                            <?php if(isset ($_POST['staff_comments']))
                            {
                                $staff_comments = sanitize_text_field($_POST['staff_comments']);
                                $staff_comments = ($_POST['staff_comments']);
/*                                  echo $staff_comments;  */
                            }?>
                    </textarea>
                <?php


/*
 * Create the form table to display comments
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


                if(!empty($applications[$selected_row]['ap_id']))
                    {
                        $table_name = "mtn_meta_data";
                        $sql = 'Select * from ' . $table_name . ' where mm_object_id = ' . $applications[$selected_row]['ap_id'] . ' order by mm_insert_date DESC';
                        $meta_data = $wpdb->get_results($sql,ARRAY_A);

                        foreach ($meta_data as $key => $value)
                        {

                            echo  '<tr>' ;
                            echo  '<td style="width: 230px">' .  $meta_data[$key]['mm_meta_data']. '</td>';
                            echo  '<td style="width: 95px">' .  $meta_data[$key]['mm_meta_user']. '</td>';
                            echo  '<td style="width: 95px">' .  $meta_data[$key]['mm_insert_date']. '</td>';
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

            if ($update_status) {
                $status_update_msg = 'Status changed from: "' . $applications[$selected_row]['ap_status'] . '" ==> "' . $status . '"';
            }
            else {
                $status_update_msg = '';
            }

            if ($update_staff_comments) {
                $comments_update_msg = 'Comments added: ' . $_POST['comments'];
            }
            else {
                $comments_update_msg = '';
            }

        ?>
        <div class="panelsuccess">
        <h3>Update Successful</h3>

        <h4>
        <?php echo $status_update_msg;?>
        <br>
        <?php echo $comments_update_msg;?>
        </h4><br>
        <label>Click <span style="color:red">Select Applicant</span> to view updated data</label>
        </div>

        <?php

        }

    }  /* Application form submitted */
} /* end of function ap_generate_form ()*/

?>
