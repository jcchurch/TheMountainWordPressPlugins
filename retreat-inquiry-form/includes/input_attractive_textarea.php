<?php

namespace Mountain\Retreat\Submission;

/**
 * Checks post data for proper input and displays the input fields
 * which receive input for the textarea identified by $name.
 *
 * The function will return the associative array containing 
 * - the text of the field (if detected) (key: $name)
 * - possibly an error message obtained along the way (key: "error")
 * - possibly a warning message obtained along the way (key: "warning")
 *
 * @param $label the desired label of this input field
 * @param $name the name of the field and of the output key
 * @param $originalValue the original value (usually a $_POST)
 * @param $required A boolean which says if this field is required (default: false)
 * @return an associative array with the following fields described above.
 */
function inputAttractiveTextarea($label, $name, $originalValue, $required=false) {
    $messagePackage = array();

    if(isset($originalValue)) {
        $value = sanitize_text_field($originalValue); 

        if (strlen($value) == 0 && $required) {
            $errormsg = $label.' required';
            $messagePackage['error'] = $errormsg;
        }
        if ((strlen($value) > 200)) {
            $errormsg = $label.' truncated to 200 characters';
            $messagePackage['warning'] = $errormsg;
        }
        else {
            $errormsg = '';
        }

        $value = substr($value, 0, 200);
        $value = preg_replace('/\n+/', "\n", trim($value));
        $messagePackage[$name] = $value;
    }

    if ($required) {
        echo "<label class='mtnlabelClass'>$label <span style='color:red'>*</span></label>\n\n";
    }
    else {
        echo "<label class='mtnlabelClass'>$label</label>\n\n";
    }
?>
    <br> 
    <textarea class="mtntextAreaClass" style="margin-left:0" type="textarea" name="<?php echo $name; ?>"><?php echo $value; ?></textarea>
    <label class="mtnerrorClass1"><?php echo $errormsg ?></label>

<?php
    return $messagePackage;
}
?>
