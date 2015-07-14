<?php

function pullApplicants() {
    global $wpdb;

    $table_name = "mtn_application";
    $sql = "SELECT * FROM $table_name";
    return $wpdb->get_results($sql,ARRAY_A);
}

function pullMetaData($id) {
    global $wpdb;

    $table_name = "mtn_meta_data";
    $sql = "SELECT * FROM $table_name WHERE mm_object_id=$id ORDER BY mm_insert_date DESC";
    return $wpdb->get_results($sql,ARRAY_A);
}

?>
