<?php

require_once('display_selection_menu.php');

function displayFilterMenu() {
    echo "<p><h2>Filtering Options</h2></p>\n";

    $statusOptions = pullUniqueValues("mtn_application", "status");
    $lastNameOptions = pullUniqueValues("mtn_application", "last_name");

    echo "<form name='filterSelection'>\n\n";

    displaySelectionMenu("Filter by Status:", "columnStatus", $statusOptions);
    displaySelectionMenu("Filter by Last Name:", "columnLastName", $lastNameOptions);

    echo "<input type='submit'>\n";
    echo "</form>\n\n";
}

?>
