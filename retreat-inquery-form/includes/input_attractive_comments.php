<?php

function inputAttractiveComments() {
    $messagePackage = array();
?>

    <label class="mtnlabelClass"> Comments </label> 
    <br>    
    <textarea class="mtntextAreaClass" style="margin-left:0" type="textarea" name="comments" > <?php 
    if(isset ($_POST['comments'])) {
        $comments = sanitize_text_field($_POST['comments']); 
            if((strlen($comments) > 200))
            { $errormsg = 'Comments truncated to 200 characters';
            }
            else
            {$errormsg = '';}
        $truncated_comments = substr($comments, 0, 200);
        $comments = preg_replace('/\n+/', "\n", trim($truncated_comments));     
        $messagePackage['comments'] = $comments;
        echo $comments;
    }?>
    </textarea>
    <label class="mtnerrorClass1"> <?php echo $errormsg ?></label>

<?php
    return $messagePackage;
}
?>
