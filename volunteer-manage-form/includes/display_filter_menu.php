<?php

namespace Mountain\Volunteer\Manage;

require_once('display_selection_menu.php');

/**
 * Displays a filter menu on the screen.
 * Currently supports Interest, Status and Last Name.
 */
function displayFilterMenu($filterCrieria) {
    $sessionOptions = pullUniqueValues("mtn_volunteer", "vl_volunteer_interest");
    $statusOptions = pullUniqueValues("mtn_volunteer", "vl_status");
    $lastNameOptions = pullUniqueValues("mtn_volunteer", "vl_lastname");

    echo "\n\n<p style='margin-bottom: 1cm;'>&nbsp;</p>\n";
    echo "<form method='post' name='filterSelection'>\n\n";

    displaySelectionMenu("Filter by Interest:", "filterSession", $sessionOptions, $filterCrieria['vl_volunteer_interest']);
    displaySelectionMenu("Filter by Status:", "filterStatus", $statusOptions, $filterCrieria['vl_status']);
    displaySelectionMenu("Filter by Last Name:", "filterLastName", $lastNameOptions, $filterCrieria['vl_lastname']);

    echo "<input type='submit' name='filter_button' value='Filter'>\n";
    echo "</form>\n\n";
}

?>
