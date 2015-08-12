<?php

function inputTextField($label, $name, $originalValue, $required=false) {

    $nbr_error_found = 0;

    if ($required) {
        echo "<label class='mtnlabelClass'>$label <span style='color:red'>*</span></label>\n\n";
    }
    else {
        echo "<label class='mtnlabelClass'>$label</label>\n\n";
    }

    $value = '';
    if(isset($originalValue)) {
        $value = sanitize_text_field($originalValue);

        if (empty($value)) {
            $errormsg = $label.' required';
            $nbr_error_found = 1;
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

    return  $nbr_error_found;
}
?>
