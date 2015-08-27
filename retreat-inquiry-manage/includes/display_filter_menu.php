<?php

namespace Mountain\Retreat\Manage;

require_once('display_selection_menu.php');

/**
 * Displays a filter menu on the screen.
 * Currently supports status and last name.
 */
function displayFilterMenu($table_name, $filters) {

    echo "\n\n<p style='margin-bottom: 1cm;'>&nbsp;</p>\n";
    echo "<form method='post' name='filterSelection'>\n\n";

    foreach ($filters as $filter) {
        if ($_POST[$filter["name"]] != "[BLANK]") {
            $original = trim(sanitize_text_field($_POST[$filter["name"]]));
        }

        $options = pullUniqueValues($table_name, $filter['column']);
        displaySelectionMenu($filter['label'], $filter['name'], $options, $original);
    }

    echo "<input type='submit' name='filter_button' value='Filter'>\n";
    echo "</form>\n\n";
}

?>
