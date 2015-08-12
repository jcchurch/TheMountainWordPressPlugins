<?php

/**
 * Pulls records from a database table based on a table_name and filters.
 *
 * @param $table_name The name of the table from which to pull records.
 * @param $filters A associative array of columns and labels. Each column-label
 *        pair will be joined by a logical AND in an SQL query.
 * @return an associative array of the query result
 */
function pullRecords1($table_name, $filters=array()) {
    global $wpdb;

    // First, test for a valid table name.
    preg_match("/^\w+$/", $table_name, $match);
    assert(count($match)==1, "Table name must fit the regular expression ^\w+$");

    // Second, test to make sure each column name is valid.
    foreach ($filters as $column => $label) {
        preg_match("/^\w+$/", $column, $match);
        assert(count($match)==1, "Column name must fit the regular expression ^\w+$");
    }

    $sql = "SELECT * FROM $table_name WHERE 1";
    foreach ($filters as $column => $label) {
        $sql .= " AND $column='$label'";
    }

    $sql .= ";";

    return $wpdb->get_results($sql,ARRAY_A);
}

?>
