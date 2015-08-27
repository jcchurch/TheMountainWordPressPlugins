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
function inputStateZip() {

    $messagePackage = array();
    $statelist = get_statelist();

    $stateerrormsg = '';
    $ziperrormsg = '';
    if(isset( $_POST["state"] )) {
        $state_abbrev = $_POST['state'];
        $messagePackage['state'] = $state_abbrev;

        if (empty($state_abbrev)) {
            $stateerrormsg = 'State required';
            $messagePackage['error'] = $stateerrormsg;
        }
    }

    if(isset($_POST["zip"])) {
        $zip = sanitize_text_field($_POST['zip']);
        $messagePackage['zip'] = $zip;

        if((strlen($zip) != 5)) {
            $ziperrormsg = 'Zip Required'; 
            $messagePackage['error'] = $ziperrormsg;
        } 
        else {
            if(!is_numeric($zip)) { 
                $ziperrormsg = 'Zip Not Numeric';
                $messagePackage['error'] = $ziperrormsg;
            }
        }                                       
    }

?>  

    <label class="mtnlabelClass" type="select">State <span style="color:red">*</span></label> 

    <select class="mtnselect" name="state">                  

    <?php foreach($statelist as $key => $value) { ?>
        <?php if ($key == $state_abbrev) { ?>
        <option value="<?php echo $key ?>" SELECTED> <?php echo $value; ?></option>
        <?php } else { ?>
        <option value="<?php echo $key ?>"> <?php echo $value; ?></option>
        <?php } ?>
    <?php } ?>

    </select>

    <label class="mtnerrorClass"><?php echo $stateerrormsg ?></label>   
        
    <label>Zip <span style="color:red">*</span></label> 
    <input class="mtninputClass"  type="text" name="zip" maxlength="5" size="5" nKeyDown="TabNext(this,'down',5)" onKeyUp="TabNext(this,'up',5,this.form.mobile_npa)"
            value="<?php echo $zip; ?>">
    <span class="mtnerrorClass"> <?php echo $ziperrormsg ?></span>
<?php

    return $messagePackage;
}

?>
