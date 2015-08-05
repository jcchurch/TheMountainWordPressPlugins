<?php

require_once('display_selection_menu.php');

/**
 * Displays a filter menu on the screen.
 * Currently supports status and last name.
 */
function displayFilterMenu($filterCrieria) {
    $sessionOptions = pullUniqueValues("mtn_application", "ap_session");
    $statusOptions = pullUniqueValues("mtn_application", "ap_status");
    $lastNameOptions = pullUniqueValues("mtn_application", "ap_lastname");

    echo "\n\n<p style='margin-bottom: 1cm;'>&nbsp;</p>\n";
    echo "<form method='post' name='filterSelection'>\n\n";

    displaySelectionMenu("Filter by Session:", "filterSession", $sessionOptions, $filterCrieria['ap_session']);
    displaySelectionMenu("Filter by Status:", "filterStatus", $statusOptions, $filterCrieria['ap_status']);
    displaySelectionMenu("Filter by Last Name:", "filterLastName", $lastNameOptions, $filterCrieria['ap_lastname']);

    echo "<input type='submit' name='filter_button' value='Filter'>\n";
    echo "</form>\n\n";
}

?>
