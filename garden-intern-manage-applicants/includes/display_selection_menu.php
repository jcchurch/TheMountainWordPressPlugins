<?php

/**
 * Displays a selection menu on the screen. The first option
 * is always "[BLANK]".
 *
 * @param $labal the lable of this selection menu
 * @param $name the internal name of this selection menus
 * @param $options the list of options from which to select
 */
function displaySelectionMenu($label, $name, $options) {
    echo "<p>$label\n";
    echo "<select name='$name'>\n";
    echo "    <option value='[BLANK]'>[BLANK]</value>\n";

    foreach ($options as $option) {
        echo "    <option value='$option'>$option</value>\n";
    }
    echo "</select>\n";
    echo "</p>\n\n";
}

?>
