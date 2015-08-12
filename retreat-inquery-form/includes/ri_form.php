<?php

require('input_text_field.php');
require('input_attractive_text_field.php');
require('input_attractive_comments.php');
require('input_mobile_field.php');
require('input_email_field.php');

function ri_form() {

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

<?php
    $messagePackage = array();

    $messagePackage += inputTextField("First Name", "firstname", $_POST['firstname'], true);
    $messagePackage += inputTextField("Last Name", "lastname", $_POST['lastname'], true);
    $messagePackage += inputMobileFields();
    $messagePackage += inputEmailField();
?>
    <br>
    <br>

    <h3><label style="color:green"> Retreat Information </label></h3>

<?php
    $messagePackage += inputAttractiveTextField("Desired Dates", "desireddates", $_POST['desireddates'], true);
    $messagePackage += inputAttractiveTextField("Retreat Name", "retreatname", $_POST['retreatname'], false);
    $messagePackage += inputAttractiveTextField("Organization", "organization", $_POST['organization'], false);
    $messagePackage += inputAttractiveTextField("Your Website", "website_url", $_POST['website_url'], false);
    $messagePackage += inputAttractiveTextField("How did you hear about The Mountain", "howheardabout", $_POST['howheardabout'], false);
    $messagePackage += inputAttractiveComments();
?>

    <br>
    <input type="submit" name="inquiryform" value="Submit Inquiry">
    <?php wp_nonce_field('ri_inquiry_form_update_');?>
    </form>
<?php

/* Process form data.  All edits and santizing has been done in the form */

 if (isset($_POST['inquiryform'])) {

 if(check_admin_referer( 'ri_inquiry_form_update_')) {


   if(!isset($messagePackage['error'])) {

    /* No errors found....process data    */
        $_post = array();

    /* insert application infomration into mtn_application */
        $ri_type = 'Retreat Inquiry';
        global $wpdb;


    /* Insert application data into mtn_application table            */
    /* Insert meta data entry showing the application was submitted  */

    $table_name =  'mtn_retreat_inquiry';
    if ($wpdb->insert($table_name, array('ri_firstname' => $messagePackage['firstname'],
            'ri_lastname'        => $messagePackage['lastname'],
            'ri_mobile'          => $messagePackage['mobile'],
            'ri_email'           => $messagePackage['email'],
            'ri_desired_dates'   => $messagePackage['desireddates'],
            'ri_retreat_name'    => $messagePackage['retreatname'],
            'ri_retreat_org'     => $messagePackage['organization'],
            'ri_retreat_org_url' => $messagePackage['website_url'],
            'ri_heard_about'     => $messagePackage['howheardabout'],
            'ri_comments'        => $messagePackage['comments'],
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
    $msg .= 'Inquiry by..............: ' . trim($messagePackage['firstname']) . ' '. trim($messagePackage['lastname']) . "\n";
    $msg .= 'Mobile Phone............: ' . $messagePackage['mobile'] . "\n";
    $msg .= 'Email Address...........: ' . $messagePackage['email'] . "\n" . "\n";
    $msg .= 'Retreat Information' . "\n" . "\n";

    $msg .= 'Desired Dates...........: ' . $messagePackage['desireddates'] . "\n";
    $msg .= 'Retreat Name............: ' . $messagePackage['retreatname'] . "\n";
    $msg .= 'Organization............: ' . $messagePackage['organization'] . "\n";
    $msg .= 'Website.................: ' . $messagePackage['website'] . "\n";
    $msg .= 'Heard About.............: ' . $messagePackage['howheardabout'] . "\n";

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

   $to = $messagePackage['email'];
/* $from has been set by an option  mtn_gi_email_send_opt      */
   $subject = "Retreat Inquiry Submission";
   $headers = "From: $from ";
   $msg = $messagePackage['firstname'] . ',' . "\n" . "\n";
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

?>
