<?php

namespace Mountain\Volunteer\Manage;

/**
 * Displays a table of applicants.
 *
 * @param $applications A sequential array of applicantions, where each
 *        element is mapped to a dictionary of values pulled from the
 *        WordPress database.
 * @param $id The id of the checked record
 * @param $columns A sequential array of columns, where each element is
 *        mapped to a dictionary containing two values: 'name' (the
 *        English representation of the column) and 'tag' (the database
 *        column id found in $applicantions)
 *
 * @return nothing - Contents displayed on the screen
 */
function displayTableOfApplicants($applications, $id, $columns) {

    if (applicationListButtonClicked() && $id < 0) { 
        echo '<p><font color="red">No id selected. Try again.</font></p>'; 
    }
?>

    <script>
    $.fn.tableScroll.defaults =
    {
        flush: true, // makes the last thead and tbody column flush with the scrollbar
        width: null, // width of the table (head, body and foot), null defaults to the tables natural width
        height: 300, // height of the scrollable area
        containerClass: 'thetable' // the plugin wraps the table in a div with this css class
    };
    </script>

    <form method="post" action="" name="applicationlist">
        <h2>List of Applications for Volunteer Positions</h2>

        <table id="thetable" cellspacing="0">
        <thead class="fixedHeader">
        <tr>
        <th>Select</th>
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

        $anID = $record['vl_id'];

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
        <input type="submit" name="application_list" value="Select Volunteer">
        </form>
        <br>
<?php

    if (applicationListButtonClicked() && $id < 0) { 
        echo '<p><font color="red">No id selected. Try again.</font></p>'; 
    }
}
?>
