<?php

function inputAttractiveComments() {
    $nbr_errors_found = 0;
?>

    <label class="mtnlabelClass"> Comments </label> 
    <br>    
    <textarea class="mtntextAreaClass" style="margin-left:0" type="textarea" name="comments" > <?php 
    if(isset ($_POST['comments'])) {
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

<?php
    return $nbr_errors_found;
}
?>
