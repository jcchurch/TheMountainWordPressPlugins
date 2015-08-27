<?php

namespace Mountain\Retreat\Submission;

require('input_text_field.php');
require('input_attractive_text_field.php');
require('input_attractive_textarea.php');
require('input_mobile_field.php');
require('input_email_field.php');
require('input_state_zip.php');
require('process_form_data.php');

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
    $messagePackage += inputTextField("Address 1", "address1", $_POST['address1'], true);
    $messagePackage += inputTextField("Address 2", "address2", $_POST['address2'], false);
    $messagePackage += inputTextField("City", "city", $_POST['city'], true);
    $messagePackage += inputStateZip();

?>
    <br>
    <br>

    <h3><label style="color:green"> Retreat Information </label></h3>

<?php
    $messagePackage += inputAttractiveTextField("Desired Dates", "desireddates", $_POST['desireddates'], true);
    $messagePackage += inputAttractiveTextField("Retreat Name", "retreatname", $_POST['retreatname'], false);
    $messagePackage += inputAttractiveTextField("Organization", "organization", $_POST['organization'], false);
    $messagePackage += inputAttractiveTextField("Your Website", "website_url", $_POST['website_url'], false);
    $messagePackage += inputAttractiveTextField("How did you hear about The Mountain?", "howheardabout", $_POST['howheardabout'], false);
    $messagePackage += inputAttractiveTextarea("Comments", "comments", $_POST['comments']);
?>

    <br>
    <input type="submit" name="inquiryform" value="Submit Inquiry">
    <?php wp_nonce_field('ri_inquiry_form_update_');?> </form>
<?php

    return $messagePackage;
} /* end Retreat_Inquiry_submission_form() */
?>
