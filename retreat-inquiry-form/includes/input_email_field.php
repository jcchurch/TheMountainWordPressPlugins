<?php

namespace Mountain\Retreat\Submission;

/**
 * Checks post data for proper input and displays the input fields
 * which receive input for an email field.
 *
 * The function will return the associative array containing 
 * - the text of the field (if detected) (key: "email")
 * - possibly an error message obtained along the way (key: "error")
 *
 * @return an associative array with the following fields described above.
 */
function inputEmailField() {
    $messagePackage = array();

?>
    <label class="mtnlabelClass"> Email <span style="color:red">*</span></label> 
    <input class="mtninputClass"  type="email" name="email" maxlength="35" size="30" 
            value=<?php if(isset( $_POST["email"] )) 
                {
                    $email = sanitize_text_field($_POST['email']);
                    echo ' "'.   $email . '"';
                    if(empty($email)) { 
                        $errormsg = 'Email Required'; 
                        $messagePackage['error'] = $errormsg;
                    }
                    else {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                            $errormsg = 'Email not valid';
                            $messagePackage['error'] = $errormsg;
                        }   
                        else {
                            $errormsg = '';
                            $messagePackage['email'] = $email;
                        }
                    }
                }?>>
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
    <br>
    <br>
<?php
    return $messagePackage;
}
?>
