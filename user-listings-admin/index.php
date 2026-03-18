<?php
if($_SESSION['role_level'] < 200) {
  header("Location: " . BASE_URL . "/index.php?page=home");
  exit;
}

$user_id = $_GET['id'];
$user_found = false;
$errors  = [];
$success = false;
  
$stmt = $conn->prepare("SELECT * FROM listings WHERE user_id_fk = ?");
if ($stmt->execute([$user_id])) {
  $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if ($listings) {
      $user_found = true;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['delete_listing'])) {
  $listing_id = $_POST['delete_listing'];

  // Delete both the listing and all its comments
  $stmt1 = $conn->prepare("DELETE FROM comments WHERE listing_id_fk = ?");
  if ($stmt1->execute([$listing_id])) {
      $success = true;
  } else {
      $errors[] = "Could not delete listing comments.";
  }

  $stmt2 = $conn->prepare("DELETE FROM listings WHERE id = ?");
  if ($stmt2->execute([$listing_id])) {
      $success = true;
  } else {
      $errors[] = "Could not delete listing.";
  }
}
?>

<main class="admin-page">
  

  <div class="admin-container">
    <?php if ($success): ?>
        <div class="alert success">
          <p>Listing deleted successfully!</p>
          <p><a href="<?= BASE_URL ?>/index.php?page=user-listings-admin&id=<?= $user_id ?>">Update list</a></p>
        </div>
    <?php endif; ?>  

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2>All user listings</h2>
    <div id="users-container">
      <?php foreach ($listings as $listing): ?>
        <a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $listing['id'] ?>">
          <div class="user-field flex-row">
            <p>
              <?= $listing['name'] ?>
            </p>
            <form method="POST" action="">
              <button class="btn-delete width-auto" type="submit" name="delete_listing" value="<?=$listing['id']?>" onclick="return confirm('Are you sure you want to permanently delete this listing? This action cannot be undone.');">
                  Delete
              </button>
            </form>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</main>