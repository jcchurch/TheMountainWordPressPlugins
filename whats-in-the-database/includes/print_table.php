<?php

function printTable($table) {
    $columns = array_keys($table[0]);

    echo "<table>\n\n";

    echo "<thead>\n\n";
    echo "<tr>\n\n";
    foreach ($columns as $column) {
        echo "    <th>$column</th>\n\n";
    }
    echo "</tr>\n\n";
    echo "</thead>\n\n";

    echo "<tbody>\n\n";
    foreach ($table as $record) {
        echo "<tr>\n";
        foreach ($columns as $column) {
            echo "<td>{$record[$column]}</td>\n";
        }
        echo "</tr>\n";
    }
    echo "</tbody>\n\n";

    echo "</table>\n\n";
}

?>
