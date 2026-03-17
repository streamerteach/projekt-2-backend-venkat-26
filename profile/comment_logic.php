<?php
if (!empty($_POST['comment'])) {
    $filename = __DIR__ . "/comments.txt";
    
    $new_comment = htmlspecialchars($_POST['comment']);
    $new_comment = trim($new_comment);
    $new_comment = stripslashes($new_comment) . "\n";
    
    $old_comments = "";
    if (file_exists($filename)) {
      $old_comments = file_get_contents($filename);
    }

    $combined_comments = $new_comment . $old_comments;
    
    $result = file_put_contents($filename, $combined_comments);
    if($result === false){
      echo "Error: comments.txt is not writable.";
    } else {
      echo "Comment added to the top!";
    }
    
}
?>