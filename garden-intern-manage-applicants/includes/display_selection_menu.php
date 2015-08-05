<?php

/**
 * Displays a selection menu on the screen. The first option
 * is always "[BLANK]" and seen as "Select▾".
 *
 * @param $labal the lable of this selection menu
 * @param $name the internal name of this selection menus
 * @param $options the list of options from which to select
 */
function displaySelectionMenu($label, $name, $options) {
    echo "$label\n";
    echo "<select name='$name'>\n";
    echo "    <option value='[BLANK]'>Select▾</option>\n";

    foreach ($options as $option) {
        echo "    <option value='$option'>$option</option>\n";
    }
    echo "</select>\n";
}

?>
