<?php

namespace Mountain\Retreat\Manage;

/**
 * Pulls records from a database table based on a table_name and filters.
 *
 * @param $table_name The name of the table from which to pull records.
 * @param $filters A associative array of columns and labels. Each column-label
 *        pair will be joined by a logical AND in an SQL query.
 * @return an associative array of the query result
 */
function pullRecords($table_name, $filters=array()) {
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

/**
 * Pulls meta data from the mtn_meta_data table where mm_object_id = $id
 *
 * @param $id The id into mtn_meta_data table.
 * @return an associative array of the query result
 */
function pullMetaData($id) {
    global $wpdb;

    $table_name = "mtn_meta_data";
    $sql = "SELECT * FROM $table_name WHERE mm_object_id=$id ORDER BY mm_insert_date DESC";
    return $wpdb->get_results($sql,ARRAY_A);
}

/**
 * Pulls unique values from a specified column of a specified table.
 *
 * @param $table_name The specified table
 * @param $column The specified column
 * @return an array of each value (duplicates removed) in the column of the table.
 */
function pullUniqueValues($table_name, $column) {
    global $wpdb;

    $sql = "SELECT $column FROM $table_name";
    $results = $wpdb->get_results($sql,ARRAY_A);

    $uniqueValues = array();

    foreach ($results as $index => $record) {
        $uniqueValues[ $record[$column] ] = 1;
    }

    return array_keys($uniqueValues);
}

?>
