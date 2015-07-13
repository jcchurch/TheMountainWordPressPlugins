<?php

/**
 * Displays a table of applicants.
 *
 * @param $applications A sequential array of applicantions, where each
 *        element is mapped to a dictionary of values pulled from the
 *        WordPress database.
 * @param $columns A sequential array of columns, where each element is
 *        mapped to a dictionary containing two values: 'name' (the
 *        English representation of the column) and 'tag' (the database
 *        column id found in $applicantions)
 *
 */
function displayTableOfApplicants($applications, $columns) {
?>
    <form method="post" action="" name="applicationlist">
        <h2>List of Applications for Mountain Positions</h2>
        <table style="border-style: solid">
        <tr>
        <td>Select</td>
<?php
          foreach ($columns as $column) {
              echo "<td>{$column['name']}</td>\n";
          }
?>
        </tr>

<?php
    foreach ($applications as $index => $record) {
        echo  '<tr>';

        if($_SERVER['REQUEST_METHOD'] == "POST" && "row$index" == $_POST["active"]) {
            echo "<td><input type='radio' name='active' value='row$index' checked></td>";
        }
        else {
            echo "<td><input type='radio' name='active' value='row$index'></td>";
        }

        foreach ($columns as $column) {
            echo "<td>{$record[$column['tag']]}</td>\n";
        }

        echo  '</tr>';
    }
?>
        </table>
        <br>
        <input type="submit" name="application_list" value="Select Applicant">
        </form>
        <br>
<?php

    if (!empty($_POST['application_list'])) { 
        if(empty($_POST['active'])) { 
            echo '<font color="red">No row selected. Try again.</font>'; 
        } 
        else { 
            echo "<font> </font>"; 
        } 
    }
}
?>
