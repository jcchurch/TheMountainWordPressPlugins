<?php

/**
 * Create an Admin page screen for the Garden Internship form
 */
function ri_admin_screen() {
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
    if (isset($_POST['ri_update'])) {
        if(check_admin_referer( 'ri_admin_options_update_')) {               
            update_option('mtn_ri_email_receive_opt', $_POST['mtn_ri_email_receive']);
            update_option('mtn_ri_email_send_opt', $_POST['mtn_ri_email_send']);
            update_option('mtn_ri_thankyou_opt', $_POST['mtn_ri_thankyou_page']);
            update_option('mtn_ri_attachment_opt', $_POST['mtn_ri_attachment']);
            update_option('mtn_ri_server_path_opt', $_POST['mtn_ri_server_path']);

            echo "<div id='message' class='updated'>Retreat Inquiry options have been updated. Refresh to see updates</div>\n";
         }
    }
} /* function ri_admin_screen() */

?>
