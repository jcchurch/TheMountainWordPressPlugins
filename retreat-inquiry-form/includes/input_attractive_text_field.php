<?php

namespace Mountain\Retreat\Submission;

function inputAttractiveTextField($label, $name, $originalValue, $required=false) {

    $messagePackage = array();

    if ($required) {
        echo "<label>$label <span style='color:red'>*</span></label>\n\n";
    }
    else {
        echo "<label>$label</label>\n\n";
    }

    echo "<br>\n\n";
    
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
