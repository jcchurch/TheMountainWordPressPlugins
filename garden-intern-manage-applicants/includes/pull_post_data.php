<?php

function pullActiveRecord() {
    /* If there is no active post, do nothing. */
    if (!isset($_POST['active'])) {
        return -1;
    }

    $recordId = str_replace("row", "", $_POST['active']);

    if (!is_numeric($recordId) || $recordId < 0) {
        return -1; 
    }

    return $recordId;
}

function pullStaffComments() {
    if(isset($_POST['staff_comments'])) {
        return trim(sanitize_text_field($_POST['staff_comments']));
    }
    return "";
}

function pullNewStatus() {
    if (isset($_POST['status'])) {
        return $_POST['status'];
    }
    return "";
}

function applicationListButtonClicked() {
    return isset($_POST['application_list']);
}

function updateButtonClicked() {
    return isset($_POST['application_form']);
}

?>
