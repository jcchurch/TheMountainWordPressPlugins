<?php

namespace Mountain\Retreat\Manage;

/**
 * Displays a table of records.
 *
 * @param $records A sequential array of records, where each
 *        element is mapped to a dictionary of values pulled from the
 *        WordPress database.
 * @param $id The id of the checked record
 * @param $columns A sequential array of columns, where each element is
 *        mapped to a dictionary containing two values: 'name' (the
 *        English representation of the column) and 'tag' (the database
 *        column id found in $records)
 *
 * @return nothing - Contents displayed on the screen
 */
function displayTableOfRecords($records, $id, $columns, $id_column, $title) {

    if (recordsListButtonClicked() && $id < 0) { 
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

    <form method="post" action="" name="recordslist">
        <h2><?php echo $title; ?></h2>

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
    foreach ($records as $record) {
        echo  '<tr>';

        $anID = $record[$id_column];

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
        <input type="submit" name="records_list" value="Select">
        </form>
        <br>
<?php

    if (recordsListButtonClicked() && $id < 0) { 
        echo '<p><font color="red">No id selected. Try again.</font></p>'; 
    }
}
?>
