<?php
include __DIR__ . "/../inc/model_listing.php";

if (!defined('APP_STARTED')) {
    exit;
}
?>

<main class="register-page">
  <div class="register-container">
    <h2>Add a new listing</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert success">
        <p>Listing created successfully! 🥳</p>
        <p><a href="<?= BASE_URL ?>/index.php?page=login">Go to listing page</a></p>
      </div>
    <?php else: ?>
      <form action="<?= BASE_URL ?>/index.php?page=new-listing" method="POST" class="form" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Listing name</label>
          <input type="text" name="name" placeholder="Enter a listing name" required>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <input type="text" name="description" placeholder="Describe the listing" required>
        </div>

        <div class="form-group">
          <label for="price">Price (euro)</label>
          <input type="number" name="price" placeholder="Enter a listing price" required>
        </div>

        <div class="form-group">
          <label for="listing_img">Select image to upload:</label>
          <input type="file" name="listing_img" id="listing_img">
        </div>

        <button type="submit" class="btn-register">Create listing</button>
      </form>
      <!--<div class="extra-links">
        <a href="<?= BASE_URL ?>/index.php?page=login">Already have an account?</a><br>
        <a href="#">Forgot password</a>
      </div>-->
    <?php endif; ?>
  </div>
</main>
