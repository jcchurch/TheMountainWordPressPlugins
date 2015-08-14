<?php

/**
 * Checks post data for proper input and displays the input fields
 * which receive input for the text field identified by $name.
 *
 * The function will return the associative array containing 
 * - the text of the field (if detected) (key: $name)
 * - possibly an error message obtained along the way (key: "error")
 *
 * @param $label the desired label of this input field
 * @param $name the name of the field and of the output key
 * @param $originalValue the original value (usually a $_POST)
 * @param $required A boolean which says if this field is required (default: false)
 * @return an associative array with the following fields described above.
 */
function inputTextField($label, $name, $originalValue, $required=false) {

    $messagePackage = array();

    if ($required) {
        echo "<label class='mtnlabelClass'>$label <span style='color:red'>*</span></label>\n\n";
    }
    else {
        echo "<label class='mtnlabelClass'>$label</label>\n\n";
    }

    $value = '';
    if(isset($originalValue)) {
        $value = sanitize_text_field($originalValue);

        if (empty($value) && $required) {
            $errormsg = $label.' required';
            $messagePackage['error'] = $errormsg;
        }
        else {
            $messagePackage[$name] = $value;
        }
    }

    if ($required) {
        echo "<input class='mtninputClass' type='text' name='$name' maxlength='30' size='30' required value='$value'>\n\n";
    }
    else {
        echo "<input class='mtninputClass' type='text' name='$name' maxlength='30' size='30' value='$value'>\n\n";
    }

    echo "<label class='mtnerrorClass'>$errormsg</label>\n\n";
    echo "<br>\n\n";

    return  $messagePackage;
}
?>
