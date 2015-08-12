<?php

function inputEmailField() {
    $nbr_errors_found = 0;

?>
    <label class="mtnlabelClass"> Email <span style="color:red">*</span></label> 
    <input class="mtninputClass"  type="email" name="email" maxlength="35" size="35" 
            value=<?php if(isset( $_POST["email"] )) 
                {
                    $email = sanitize_text_field($_POST['email']);
                    echo ' "'.   $email . '"';
                    if(empty($email)) { 
                        $errormsg = 'Email Required'; 
                        ++$nbr_errors_found;
                    }
                    else {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                             $errormsg = 'Email not valid';
                             ++$nbr_errors_found;
                        }   
                        else {
                            $errormsg = '';
                        }
                    }
                }?>>
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
    <br>
    <br>
<?php
    return $nbr_errors_found;
}
?>
