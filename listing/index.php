<?php
$errors = [];
$success = false;
include __DIR__ . "/../inc/model_listing.php";
include __DIR__ . "/../inc/model_mark_interested.php";

if (!defined('APP_STARTED')) {
    exit;
}

?>

<main class="page-section intro-section">
<article class="">
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
        <p><?= $totalInterested ?> people in total have shown interest in this listing<?php if ($isInterested): ?> (including you)<?php endif; ?>.</p>
        <form action="<?= BASE_URL ?>/index.php?page=listing&id=<?= $_GET['id']; ?>" method="POST">
          
          <?php if ($isInterested): ?>
              <button type="submit" name="action" value="not_interested">Mark me as not interested</button>
          <?php else: ?>
              <button type="submit" name="action" value="interested">Mark me as interested</button>
          <?php endif; ?>
        </form>
      
    <?php endif; ?>
  </div>
</main>
