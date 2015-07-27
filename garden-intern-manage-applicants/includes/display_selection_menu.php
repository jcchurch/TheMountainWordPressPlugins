<?php

function displaySelectionMenu($label, $name, $options) {
    echo '<p>$label\n';
    echo "<select name='$name'>\n";

    foreach ($options as $option) {
        echo "    <option value='$option'>$option</value>\n";
    }
    echo "</select>\n";
    echo "</p>\n\n";
}

?>
