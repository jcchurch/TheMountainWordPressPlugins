<?php

/**
 * Checks post data for proper input and displays the input fields
 * which receive input for a mobile number.
 *
 * The function call will return an associative array containing
 * a mobile number (key: "mobile") and possibly an error message
 * obtained along the way (key: "error").
 *
 * @return an associative array with the following fields described above.
 */
function inputMobileFields() {
    $messagePackage = array();
    
    /* Check for the three parts of a phone number */
    if(isset( $_POST["mobile_npa"] )) {
        $mobile_npa = sanitize_text_field($_POST['mobile_npa']);
    }

    if(isset( $_POST["mobile_nxx"] )) {
        $mobile_nxx = sanitize_text_field($_POST['mobile_nxx']);
    }

    if(isset( $_POST["mobile_nbr"] )) {
        $mobile_nbr = sanitize_text_field($_POST['mobile_nbr']);
    }

    /* perform edit on the assemble mobile number */
    $mobile = $mobile_npa . $mobile_nxx . $mobile_nbr;
    $messagePackage['mobile'] = $mobile;

    if((strlen($mobile) != 10)) { 
        $errormsg = 'Mobile Required'; 
        $messagePackage['error'] = $errormsg;
    }
    else {
        if(!is_numeric($mobile)) {
              $errormsg = 'Mobile Not Numeric';
              $messagePackage['error'] = $errormsg;
        }
    }

?>
    <label class="mtnlabelClass"> Mobile <span style="color:red">*</span></label>               

    <input class="mtninputClass" type="tel" name="mobile_npa" maxlength="3" size="3" nKeyDown="TabNext(this,'down',3)" onKeyUp="TabNext(this,'up',3,this.form.mobile_nxx)"
            value="<?php echo $mobile_npa; ?>">

    <input class="mtninputClass" type="tel" name="mobile_nxx" maxlength="3" size="3" nKeyDown="TabNext(this,'down',3)" onKeyUp="TabNext(this,'up',3,this.form.mobile_nbr)"
            value="<?php echo $mobile_nxx; ?>">
    <span> - </span>       

    <input class="mtninputClass" type="tel" name="mobile_nbr" maxlength="4" size="4" nKeyDown="TabNext(this,'down',4)" onKeyUp="TabNext(this,'up',4,this.form.email)"
            value="<?php echo $mobile_nbr; ?>">

    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
    <br>

<?php
   return $messagePackage;
} /* end Retreat_Inquiry_submission_form() */

?>
