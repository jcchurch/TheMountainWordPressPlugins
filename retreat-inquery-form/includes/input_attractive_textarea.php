<?php

function inputAttractiveTextarea($label, $name, $originalValue) {
    $messagePackage = array();

    if(isset($originalValue)) {
        $value = sanitize_text_field($originalValue); 

        if ((strlen($value) > 200)) {
            $errormsg = $label.' truncated to 200 characters';
            $messagePackage['error'] = $errormsg;
        }
        else {
            $errormsg = '';
        }

        $value = substr($value, 0, 200);
        $value = preg_replace('/\n+/', "\n", trim($value));
        $messagePackage[$name] = $value;
    }
?>
    <label class="mtnlabelClass"><?php echo $label; ?></label> 
    <br> 
    <textarea class="mtntextAreaClass" style="margin-left:0" type="textarea" name="<?php echo $name; ?>"><?php echo $value; ?></textarea>
    <label class="mtnerrorClass1"><?php echo $errormsg ?></label>

<?php
    return $messagePackage;
}
?>
