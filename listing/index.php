<?php
include __DIR__ . "/../inc/model_listing.php";

if (!defined('APP_STARTED')) {
    exit;
}
?>

<main class="register-page">
  <div class="register-container">
    <h2>Listing</h2>

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
        <p><a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $listing_id ?>">Go to listing page</a></p>
      </div>
    <?php else: ?>
      
    <?php endif; ?>
  </div>
</main>
