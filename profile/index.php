<?php
    include 'profile_img_logic.php';
    include 'comment_logic.php';

    /*if(empty($_SESSION['username'])) {
        header("Location: ./index.php?page=home/");
    }*/

?>

 <main class="">
  <div class="page-section">
  <h1>Profile Page</h1><br>
  <div class="profileManage">
    <div class="manage-card">
        <h3>Update Profile</h3>
        <p>Edit your profile details and image.</p>
         <a  href="index.php?page=profile-update"   class="manage-btn">Update</a>
    </div>
     <div class="manage-card danger">
        <h3>Remove Profile</h3>
        <p>Delete your profile and related data.</p>
         <a href="index.php?page=delete-profile" class="manage-btn delete-btn">Remove</a>
    </div>
  </div>
  

  <h2>Profile image:</h2>
    <form action="" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="upload-profile-img">
    </form>

    <?php

    $dir = __DIR__ . '/pictures';
    $files = scandir($dir);

    // Sort by last modified time (newest first)
    usort($files, function ($a, $b) use ($dir) {
        return filemtime($dir . '/' . $b) <=> filemtime($dir . '/' . $a);
    });

    foreach ($files as $file) {

        // Skip current/parent directory
        if ($file === '.' || $file === '..') {
            continue;
        }

        // Only allow images
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            continue;
        }

        // Output image
        echo '<img src="profile/pictures/' . htmlspecialchars($file) . '" 
                style="width:150px; height:auto; margin:10px;">';
    }
?>
</div>

<div class="page-section">
    <h2>Comments</h2><br>
    <form method="post" action="">
        <input type="text" name="comment" placeholder="Enter your comment" required>
        <button type="submit">Post Comment</button>
    </form>

    <h3>Recent Comments:</h3><br>
    <?php
    $filename = __DIR__ . "/comments.txt";

    if (file_exists($filename)) {

        $comments = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!empty($comments)) {
            foreach ($comments as $comment) {

                echo "<p>" . $comment . "</p><br>";
            }
        } else {
            echo "<p>No comments yet. Be the first!</p>";
        }
    } else {
        echo "<p>Comment file not found.</p>";
    }
    ?>
</div>
 
 </main>