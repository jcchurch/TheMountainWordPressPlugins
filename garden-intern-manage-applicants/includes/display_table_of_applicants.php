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
function displayTableOfApplicants($applications, $id, $columns) {

    if (applicationListButtonClicked() && $id < 0) { 
        echo '<p><font color="red">No id selected. Try again.</font></p>'; 
    }
?>
    <form method="post" action="" name="applicationlist">
        <p><h2>List of Applications for Mountain Positions</h2></p>
        <table class="scrollTable">
        <thead class="fixedHeader">
        <tr>
        <th>Select</td>
<?php
          foreach ($columns as $column) {
              echo "<th>{$column['name']}</th>\n";
          }
?>
        </tr>
        </thead>
        <tbody class="scrollContent">

<?php
    foreach ($applications as $index => $record) {
        echo  '<tr>';

        $anID = $record['ap_id'];

        if($anID == $id) {
            echo "<td><input type='radio' name='active' value='id$anID' checked></td>";
        }
        else {
            echo "<td><input type='radio' name='active' value='id$anID'></td>";
        }

        foreach ($columns as $column) {
            echo "<td>{$record[$column['tag']]}</td>\n";
        }

        echo  '</tr>';
    }
?>
        </tbody>
        </table>
        <br>
        <input type="submit" name="application_list" value="Select Applicant">
        </form>
        <br>
<?php

    if (applicationListButtonClicked() && $id < 0) { 
        echo '<p><font color="red">No id selected. Try again.</font></p>'; 
    }
}
?>
