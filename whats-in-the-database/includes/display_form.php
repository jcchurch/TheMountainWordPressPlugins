<?php

function displayForm() {

?>
<form  method="post" name="tableName" enctype="multipart/form-data" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

<?php
    $messagePackage = inputTextField("Table Name", "tablename", $_POST['tablename']);
?>

<input type="submit" name="inquiryform" value="Submit Inquiry">
</form>

<?php

    return $messagePackage['tablename'];
}

?>
