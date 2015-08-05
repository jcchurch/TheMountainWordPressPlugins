<?php
/*
Plugin Name: Retreat Inquiry Form
Plugin URI: No URI
Description: The plugin allows a form to be included in a blog or page to submit a Retreat Inquiry.
Version: 1.0
Author: Jay Kiskel
Author URI: http://studio205.tv
*/

/* Functions in this file:
  ri_admin_screen() : Creates an admin screen to set the Mountain staff emails to send / receive 
  ri_plugin_menu()  : Adds a stand alone Retreat Inquiry menu option 
  ri_create_table() : Checks if the database table wp_mtn_retreat_inquiry exists, if not creates table and version number in options table.
  mtn_retreat_inquiry_form() : Generates the Retreat Inquiry Submission form, captures/edits data, sends emails and writes row to database table
  ri_shortcode() : Generates shortcode for form
 
  Also see function.php for Mountain functions for get_options, send_mail and error trapping and reporting
  
*/
function ri_admin_screen()
/* Create an Admin page screen for the Garden Internship form */
{
    ?>
    <div class="wrap"><?php screen_icon(); ?>
    <h2>Retreat Inquiry Submission Form Admin</h2>
    <p>On this admin page you (1) designate the MountainStaff to receive the inquiry submission, (2) designate the Mountain staff who sends a thank you email to the submitter,
    (3) Establish the Thank You webpage shown following the submission and (4) GEt short code for the form</p> 
    <form action="" method="post" id="ri-inquiry-submission_admin_form">
    
        
        <h3><label>Mountain Staff Email to RECEIVE the Retreat Inquiry - CANNOT BE BLANK</label> </h3>
        <p><input type="text" name="mtn_ri_email_receive" size="60"
                value="<?php echo esc_attr( get_option('mtn_ri_email_receive_opt') ); ?>" /></p>
                
        <h3><label>Mountain Staff Email to SEND the Retreat Inquiry Thank You - CANNOT BE BLANK</label> </h3>
        <p><input type="text" name="mtn_ri_email_send" size="60"
                value="<?php echo esc_attr( get_option('mtn_ri_email_send_opt') ); ?>" /></p>       
                
        <h3><label>URL of Website Thank You Page for Retreat Submission - CANNOT BE BLANK</label> </h3>
        <p><input type="text" name="mtn_ri_thankyou_page" size="80"
                value="<?php echo esc_attr( get_option('mtn_ri_thankyou_opt') ); ?>" /></p> 
            
        <h3><label>Server File Path for Attachment - CANNOT BE BLANK</label> </h3>
        <p><input type="text" name="mtn_ri_server_path" size="80"
                value="<?php echo esc_attr( get_option('mtn_ri_server_path_opt') ); ?>" /></p>          
        
        
        <h3><label>Name of File to be Sent Inquiry - CANNOT BE BLANK</label> </h3>
        <p><input type="text" name="mtn_ri_attachment" size="80"
                value="<?php echo esc_attr( get_option('mtn_ri_attachment_opt') ); ?>" /></p>       
            
        <h3><label>Shortcode for Retreat Inquiry Submission Form </label></h3>
        <input type="text" value="[Retreat_Submission_Form]">
        
        <p><input type="submit" name="ri_update" value="Update Options" /></p>

        <?php wp_nonce_field('ri_admin_options_update_');?>
    </form>
    </div>
    <?php
    
     /* if Admin Panel Form submitted, process updates    */
     if (isset($_POST['ri_update'])) 
     {
        if(check_admin_referer( 'ri_admin_options_update_'))
            {               
            update_option('mtn_ri_email_receive_opt', $_POST['mtn_ri_email_receive']);
            update_option('mtn_ri_email_send_opt', $_POST['mtn_ri_email_send']);
            update_option('mtn_ri_thankyou_opt', $_POST['mtn_ri_thankyou_page']);
            update_option('mtn_ri_attachment_opt', $_POST['mtn_ri_attachment']);
            update_option('mtn_ri_server_path_opt', $_POST['mtn_ri_server_path']);
            ?>
            <div id="message" class="updated">Retreat Inquiry options have been updated.  Refresh to see updates</div>
            <?php   
                                    
            }   
     }
        
} /* function ri_admin_screen() */

function ri_plugin_menu()
{
    add_menu_page('Retreat Inquiry', 'Retreat Inquiry Form','manage_options','ri_applic_plugin','ri_admin_screen');
}

/* add Retreat Inquiry Menu as a separate menu option on the Admin page */
    add_action('admin_menu','ri_plugin_menu');


function mtn_retreat_inquiry_create()
{
    /* 1. Create custom table mtn_retreat_inquiry that will hold retreat inquire submissions                    */
    /* 2. Note: this plugin uses the custom table mtn_meta_data that will hold comments made on submissions     */
    /*    auto generated comments when a inquiry status is changed                                              */  
    
    
    global $wpdb;

    $table_name = "mtn_retreat_inquiry";

    // will return NULL if there isn't one
    if ( $wpdb->get_var('SHOW TABLES LIKE ' . $table_name) != $table_name )
    {
        $sql = 'CREATE TABLE ' . $table_name . '(
                ri_id INTEGER(10) UNSIGNED AUTO_INCREMENT,
                ri_firstname VARCHAR (30), 
                ri_lastname VARCHAR (30),           
                ri_address1 VARCHAR (35),
                ri_address2 VARCHAR (35),
                ri_city VARCHAR (35),
                ri_state VARCHAR (2),
                ri_zip VARCHAR (5),         
                ri_mobile VARCHAR (10),
                ri_email VARCHAR (35),          
                ri_desired_dates VARCHAR (35),          
                ri_retreat_name VARCHAR (35),
                ri_retreat_org VARCHAR (35),                        
                ri_retreat_org_url VARCHAR (35),                        
                ri_heard_about VARCHAR (35),
                ri_comments VARCHAR (255),
                ri_type VARCHAR (30),
                ri_status VARCHAR (20),
                ri_submit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY  (ri_id) )';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } /* Show tables like */
} /* mtn_retreat_inquiry_create */

register_activation_hook(__FILE__,'mtn_retreat_inquiry_create');


function retreat_inquiry_form() {
    $nbr_errors_found = 0;
    
?>
<SCRIPT LANGUAGE="JavaScript"> 
// ------------------------------------------------------------------- 
// TabNext() 
// Function to auto-tab phone field 
// Arguments: 
//   obj :  The input object (this) 
//   event: Either 'up' or 'down' depending on the keypress event 
//   len  : Max length of field - tab when input reaches this length 
//   next_field: input object to get focus after this one 
// ------------------------------------------------------------------- 
var phone_field_length=0; 
function TabNext(obj,event,len,next_field) { 
    if (event == "down") { 
        phone_field_length=obj.value.length; 
        } 
    else if (event == "up") { 
        if (obj.value.length != phone_field_length) { 
            phone_field_length=obj.value.length; 
            if (phone_field_length == len) { 
                next_field.focus(); 
                } 
            } 
        } 
    } 
</SCRIPT> 


<!--                     Start  The Retreat Inquiry           Form            -->



<form  method="post" name="retreatinquiry" enctype="multipart/form-data" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">  

   
    <h3><label style="color:green"> Your Information </label></h3>  
    
    <label class="mtnlabelClass"> First <span style="color:red">*</span></label>            
    <input class="mtninputClass" type="text" name="firstname" maxlength="30" size="30" required                 
            value=<?php if(isset( $_POST["firstname"] )) 
                {
                    $firstname = sanitize_text_field($_POST['firstname']); 
    
                    echo  ' "'. $firstname . '"';   
                    
                    if (empty($firstname))
                    {   
                       $errormsg = 'First name required';
                       ++$nbr_errors_found; 
                    }
                    else    
                    { $errormsg = ' ';}     
                }?>>                        
    
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
            
    <br>            
    <label class="mtnlabelClass"> Last <span style="color:red">*</span></label>
    <input  class="mtninputClass" type="text" name="lastname" maxlength="30" size="30" required                 
            value=<?php if(isset( $_POST["lastname"] )) 
                {
                    $lastname = sanitize_text_field($_POST['lastname']);
                    echo ' "'.  $lastname . '"'; 
                    
                    if (empty($lastname))
                    {
                        $errormsg = 'Last name required';
                        ++$nbr_errors_found;
                    }
                    else
                    { $errormsg = ' ';}                         
                }?>>
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
    
    <br>
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
                    if((strlen($mobile) != 10)) 
                        { 
                            $errormsg = 'Mobile Required'; 
                           ++$nbr_errors_found;
                        }
                    else
                    {
                        If(!is_numeric($mobile)) 
                            {
                              $errormsg = 'Mobile Not Numeric';
                              ++$nbr_errors_found;
                            }
                        else 
                           {$errormsg = '';}    
                    }

                }?>>                        
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
            
    <br>
    <label class="mtnlabelClass"> Email <span style="color:red">*</span></label> 
    <input class="mtninputClass"  type="email" name="email" maxlength="35" size="35" 
            value=<?php if(isset( $_POST["email"] )) 
                {

                    $email = sanitize_text_field($_POST['email']);
                    echo ' "'.   $email . '"';
                    if(empty($email)) 
                        { 
                        $errormsg = 'Email Required'; 
                        ++$nbr_errors_found;
                        }
                    else
                        {
                            If(filter_var($email, FILTER_VALIDATE_EMAIL) === false)  
                                { 
                                    $errormsg = 'Email not valid';
                                    ++$nbr_errors_found;
                                }   
                            else 
                            {$errormsg = '';}       
                        }
                }?>>
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
    <br>
    <br>
            
    <h3><label style="color:green"> Retreat Information </label></h3>       
 
    <label > Desired Dates <span style="color:red">*</span></label> <br>
    <input class="mtninputClass" type="text" name="desireddates" maxlength="35" size="35" 
            value=<?php if(isset( $_POST["desireddates"] )) 
                {
                    $desireddates = sanitize_text_field($_POST['desireddates']);
                    echo ' "'.  $desireddates . '"'; 
                    if (empty($desireddates))
                    {
                        $errormsg = 'Desired dates required';
                        ++$nbr_errors_found;
                    }
                    else
                    { $errormsg = ' ';}

                }?>>
    <label class="mtnerrorClass"> <?php echo $errormsg ?></label>   
            
    <br>     
    <label> Retreat Name</label> 
    <br>
    <input class="mtninputClass" type="text" name="retreatname" maxlength="35" size="35" 
            value=<?php if(isset( $_POST["retreatname"] )) 
                {
                    $retreatname = sanitize_text_field($_POST['retreatname']);
                    echo ' "'.  $retreatname . '"'; 
                }?>>                        
    
    <br>
    <label > Organization </label>
    <br>
    <input class="mtninputClass" type="text" name="organization" maxlength="35" size="35" 
            value=<?php if(isset( $_POST["organization"] )) 
                {
                    $organization  = sanitize_text_field($_POST['organization']);
                    echo ' "'. $organization . '"';    
                }?>>        
                        
    <br>    
    <label > Your Website </label> 
    <br>
    <input class="mtninputClass" type="text" name="website_url" maxlength="35" size="35" 
            value=<?php if(isset( $_POST["website_url"] )) 
                {
                    $website_url = sanitize_text_field($_POST['website_url']);
                    echo ' "'. $website_url . '"';    
                }?>>        
                        
                        
    <br>
    <label > How did you hear about The Mountain? </label>
    <br><input class="mtninputClass" type="text" name="howheardabout" maxlength="35" size="35" 
        value=<?php if(isset( $_POST["howheardabout"] )) 
            {
                $howheardabout = sanitize_text_field($_POST['howheardabout']);
                echo ' "'. $howheardabout . '"';    
            }?>>
    </br>   
            

    </textarea>
    <br>
    <label class="mtnlabelClass"> Comments </label> 
    <br>    
    <textarea class="mtntextAreaClass" style="margin-left:0" type="textarea" name="comments" > <?php 
    if(isset ($_POST['comments'])) 
    {
        $comments = sanitize_text_field($_POST['comments']); 
            if((strlen($comments) > 200))
            { $errormsg = 'Comments truncated to 200 characters';
            ++$nbr_errors_found;
            }
            else
            {$errormsg = '';}
        $truncated_comments = substr($comments, 0, 200);
        $comments = preg_replace('/\n+/', "\n", trim($truncated_comments));     
        echo $comments;
    }?>
    </textarea>
    <label class="mtnerrorClass1"> <?php echo $errormsg ?></label>
    
    <br>    
    <input type="submit" name="inquiryform" value="Submit Inquiry"> 
    <?php wp_nonce_field('ri_inquiry_form_update_');?>  
    </form>
 <?php 
 
 
/* Process form data.  All edits and santizing has been done in the form */ 
 
 if (isset($_POST['inquiryform'])) {    

 if(check_admin_referer( 'ri_inquiry_form_update_')) {

    
   if($nbr_errors_found == 0) {
    
    /* No errors found....process data    */     
        $_post = array();
            
    /* insert application infomration into mtn_application */
        $ri_type = 'Retreat Inquiry';   
        global $wpdb;
        
        
    /* Insert application data into mtn_application table            */
    /* Insert meta data entry showing the application was submitted  */ 
    
    $table_name =  'mtn_retreat_inquiry';
    if ($wpdb->insert($table_name, array('ri_firstname' => $firstname,
            'ri_lastname'        => $lastname,
            'ri_mobile'          => $mobile,
            'ri_email'           => $email,     
            'ri_desired_dates'   => $desireddates,
            'ri_retreat_name'    => $retreatname,
            'ri_retreat_org'     => $organization,
            'ri_retreat_org_url' => $website_url,
            'ri_heard_about'     => $howheardabout,         
            'ri_comments'        => $comments,
            'ri_type'            => $ri_type,
            'ri_status'          => 'Submitted')) == FALSE)
    
    { $mtn_system_error_msg_severity = 'High';
    $mtn_system_error_msg_post = ' Post : ' . get_the_title();
    $mtn_system_error_msg_file = ' File: ' . __FILE__;
    $mtn_system_error_msg_line = ' Line: ' . __LINE__;
    $mtn_system_error_msg = 'Err 003: Database insert failure ' . $table_name  . $mtn_system_error_msg_post . $mtn_system_error_msg_file .  $mtn_system_error_msg_line;
    /* call error function which writes to error log */
    mtn_system_error($mtn_system_error_msg_severity, $mtn_system_error_msg);
    }
    
    /*------------------------------------------------------------------------------------*/
    /*                 Set Up Email                                                       */
    /* 1. Get Option for Mountain Staff to recieve email.  See Admin Panel                */
    /* 1. Get Option for Mountain Staff to send email.  See Admin Panel                   */
    /* 2. Set Up Subject and Headers                                                      */
    /* 3. Define Boundary to define where the attachment begins and ends                  */
    /*------------------------------------------------------------------------------------*/

    $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;    
    $to = get_mtn_options('mtn_ri_email_receive_opt',$mtn_system_error_msg_data);
    
    $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;
    $from = get_mtn_options('mtn_ri_email_send_opt',$mtn_system_error_msg_data);    
    
        
    $subject = "Retreat Inquiry";
    $headers = "From: $from ";
    
    /* This message with be concatenated in the $message.  See Define Plain Text Boundary  */
    $msg = 'Retreat Inquiry Submitted';
    $msg .= 'Submitter Information' . "\n" . "\n";
    $msg .= 'Inquiry by............: ' . trim($firstname) . ' '. trim($lastname) . "\n";
    $msg .= 'Mobile Phone.....: ' . $mobile . "\n";
    $msg .= 'Email Address....: ' . $email . "\n" . "\n";
    $msg .= 'Retreat Information' . "\n" . "\n";            
            
    $msg .= 'Desired Dates...........: ' . $desireddates . "\n";
    $msg .= 'Retreat Name............: ' . $retreatname . "\n";
    $msg .= 'Organization..............: ' . $organization . "\n";          
    $msg .= 'Website.....................: ' . $website . "\n";                 
    $msg .= 'Heard About..............: ' . $howheardabout . "\n";                  
            
    $msg .= 'Comments :' . "\n" . "\n";
    $msg .= trim($comments);
    
    /* Define Boundary to define where the attachment begins and ends. */
    
    // boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        
    // Tell header about the boundary
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
        
    // Define Plain Text boundary
    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $msg . "\n\n";
    $message .= "--{$mime_boundary}\n";
      
    // Send the email to the Mountain Staff  call send mail function
    
    $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;
    send_mtn_mail($to,$subject,$message,$headers,$mtn_system_error_msg_data);   
        
    
    /* Send email to person making retreat inquiry and include an attachment with additinal info      */
  
   $to = $email;
/* $from has been set by an option  mtn_gi_email_send_opt      */     
   $subject = "Retreat Inquiry Submission";
   $headers = "From: $from "; 
   $msg = $firstname . ',' . "\n" . "\n";
   $msg .= 'Thank you very much for considering The Mountain for your next retreat.' . "\n" . "\n";
   $msg .= 'A Mountain representatives will be contacting your shortly.' . "\n" . "\n";
   $msg .= 'The Mountain Sales Team';
   
   // boundary
   $semi_rand = md5(time());
   $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    
   // Tell header about the boundary
   $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
    
   // Define Plain Text boundary
   $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $msg . "\n\n";
   $message .= "--{$mime_boundary}\n";
   
   
   /* get server path and file from Admin sreen options */
  
    $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;
    $home_path = get_mtn_options('mtn_ri_server_path_opt',$mtn_system_error_msg_data);
     
    $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;
    $attachment_name = get_mtn_options('mtn_ri_attachment_opt',$mtn_system_error_msg_data);
     
    $attachment = $home_path . $attachment_name;
    
    $file_names = array($attachment_name);
  
    $files = array($attachment);
   
   /* this code from http://stackoverflow.com/questions/22247464/php-how-to-attach-existing-file-from-server-and-send-email */
   
   for ($x = 0; $x < count($files); $x++) {
    
    if (substr($files[$x],0,4) == 'http') 
    {           
        $handle = fopen($files[$x], "rb");
        $data = stream_get_contents($handle);
        fclose($handle);
    }
    else
    {   
        $file = fopen($files[$x], "rb");
        $data = fread($file, filesize($files[$x]));
        fclose($file);
    }   
        
/*      $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . */
/*      "Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" . */

    
    $data = chunk_split(base64_encode($data));
    $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$file_names[$x]\"\n" .
    "Content-Disposition: attachment;\n" . " filename=\"$file_names[$x]\"\n" .
    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    $message .= "--{$mime_boundary}\n";
   }
            
   
   // call send mail function
   $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;
   send_mtn_mail($to,$subject,$message,$headers,$mtn_system_error_msg_data);
    
    /* After all processing, send applicant to a Thank You page on the website */ 
    /* URL of Thank You page set in Plugin Admin Panel                         */  
    
   $mtn_system_error_msg_data = ' Post : ' . get_the_title() . ' File: ' . __FILE__ . ' Line: ' . __LINE__;
   $thank_you_url = get_mtn_options('mtn_ri_thankyou_opt',$mtn_system_error_msg_data);
    /* _parent option forces Oops page to replace the current page having a error vs. openig the Oops in a new tab */
    $link =  '<script type="text/javascript" language="javascript"> window.open("' .$thank_you_url. '","_parent" );</script>';    
   echo $link;
    
    }
    
    
 } /* if no errors */
 
 } /* end of nounce check */

} /* end Retreat_Inquiry_submission_form() */


function ri_shortcode() 
    {
    ob_start();
    retreat_inquiry_form(); 
    return ob_get_clean();
    }
 
add_shortcode( 'Retreat_Submission_Form', 'ri_shortcode' );
 


