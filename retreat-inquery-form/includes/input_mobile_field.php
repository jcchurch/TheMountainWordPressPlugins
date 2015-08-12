<?php

function inputMobileFields() {
    $messagePackage = array();
?>
    <label class="mtnlabelClass"> Mobile <span style="color:red">*</span></label>               
    <input class="mtninputClass" type="tel" name="mobile_npa" maxlength="3" size="3" nKeyDown="TabNext(this,'down',3)" onKeyUp="TabNext(this,'up',3,this.form.mobile_nxx)"
            value=<?php if(isset( $_POST["mobile_npa"] )) 
                {
                    $mobile_npa = sanitize_text_field($_POST['mobile_npa']);
                    echo $mobile_npa;                                             
                }?>>

       <input class="mtninputClass" type="tel" name="mobile_nxx" maxlength="3" size="3" nKeyDown="TabNext(this,'down',3)" onKeyUp="TabNext(this,'up',3,this.form.mobile_nbr)"
            value=<?php if(isset( $_POST["mobile_nxx"] )) 
                {
                    $mobile_nxx = sanitize_text_field($_POST['mobile_nxx']);
                    echo $mobile_nxx;
                }?>>
                    <span > - </span>       
        <input class="mtninputClass" type="tel" name="mobile_nbr" maxlength="4" size="4" nKeyDown="TabNext(this,'down',4)" onKeyUp="TabNext(this,'up',4,this.form.email)"
            value=<?php if(isset( $_POST["mobile_nbr"] )) 
                {

                    $mobile_nbr = sanitize_text_field($_POST['mobile_nbr']);
                    echo $mobile_nbr;
                    /* perform edit on the assemble mobile number */
                    $mobile = $mobile_npa . $mobile_nxx . $mobile_nbr;
                    $messagePackage['mobile'] = $mobile;
                    if((strlen($mobile) != 10)) 
                        { 
                            $errormsg = 'Mobile Required'; 
                            $messagePackage['error'] = $errormsg;
                        }
                    else
                    {
                        If(!is_numeric($mobile)) 
                            {
                              $errormsg = 'Mobile Not Numeric';
                              $messagePackage['error'] = $errormsg;
                            }
                        else {
                            $errormsg = '';
                        }    
                    }

                }?>>                        
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
    <br>

<?php
   return $messagePackage;
} /* end Retreat_Inquiry_submission_form() */

?>
