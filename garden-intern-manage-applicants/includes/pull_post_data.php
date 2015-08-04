<?php

function pullActiveRecordIdentifier() {
    /* If there is no active post, do nothing. */
    if (!isset($_POST['active'])) {
        return -1;
    }

    $recordId = str_replace("id", "", $_POST['active']);

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

function filterButtonClicked() {
    return isset($_POST['filter_button']);
}

function pullFilterCriteria() {
    $filterCriteria = array();

    $filterSelections = array(
          'filterStatus' => 'ap_status'
        , 'filterLastName' => 'ap_lastname'
    );

    if (filterButtonClicked()) {
        foreach ($filterSelections as $name => $column) {
            if ($_POST[$name] != "[BLANK]") {
                $filterCriteria[$column] = trim(sanitize_text_field($_POST[$name]));
            }
        }
    }

    return $filterCriteria;
}

?>
