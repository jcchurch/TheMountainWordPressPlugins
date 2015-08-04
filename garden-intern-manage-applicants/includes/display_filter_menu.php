<?php

require_once('display_selection_menu.php');

/**
 * Displays a filter menu on the screen.
 * Currently supports status and last name.
 */
function displayFilterMenu() {
    echo "<p><h2>Filtering Options</h2></p>\n";

    $statusOptions = pullUniqueValues("mtn_application", "ap_status");
    $lastNameOptions = pullUniqueValues("mtn_application", "ap_lastname");

    echo "<form method='post' name='filterSelection'>\n\n";

    displaySelectionMenu("Filter by Status:", "filterStatus", $statusOptions);
    displaySelectionMenu("Filter by Last Name:", "filterLastName", $lastNameOptions);

    echo "<input type='submit' name='filter_button' value='Filter Applicants'>\n";
    echo "</form>\n\n";
}

?>
