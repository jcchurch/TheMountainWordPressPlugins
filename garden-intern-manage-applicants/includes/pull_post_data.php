<?php

namespace Mountain\Garden\Manage;

/**
 * Returns the active identifier that should be examined
 * or updated. If there is no active identifier, returns
 * -1.
 *
 * @return the active identifier or -1
 */
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

/**
 * Returns the staff comments. If there are no staff
 * comments, returns an empty string.
 *
 * @return the staff comments or an empty string.
 */
function pullStaffComments() {
    if(isset($_POST['staff_comments'])) {
        return trim(sanitize_text_field($_POST['staff_comments']));
    }
    return "";
}

/**
 * Returns the new status from the update form.
 * If there is no new status, returns an empty string.
 *
 * @return the new status or an empty string.
 */
function pullNewStatus() {
    if (isset($_POST['status'])) {
        return $_POST['status'];
    }
    return "";
}

/**
 * Returns true if the application list button was clicked.
 *
 * @return boolean if the application list button was clicked.
 */
function applicationListButtonClicked() {
    return isset($_POST['application_list']);
}

/**
 * Returns true if the update button was clicked.
 *
 * @return boolean if the update button was clicked.
 */
function updateButtonClicked() {
    return isset($_POST['application_form']);
}

/**
 * Returns true if the filter button was clicked.
 *
 * @return boolean if the filter button was clicked.
 */
function filterButtonClicked() {
    return isset($_POST['filter_button']);
}

/**
 * Returns the list of criteria set forth from the
 * filter form. If there is no criteria, returns an
 * emtpy list.
 *
 * @return an array of criteria by which to filter (or an empty list)
 */
function pullFilterCriteria() {
    $filterCriteria = array();

    $filterSelections = array(
          'filterStatus' => 'ap_status'
        , 'filterLastName' => 'ap_lastname'
        , 'filterSession' => 'ap_session'
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
