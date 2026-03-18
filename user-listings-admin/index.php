<?php
$user_id = $_GET['id'];
$user_found = false;
  
$stmt = $conn->prepare("SELECT * FROM listings WHERE id = ?");
if ($stmt->execute([$user_id])) {
  $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if ($listings) {
      $user_found = true;
  }
}
?>

<main class="admin-page">
  <div class="admin-container">
    <h2>All user listings</h2>
    <div id="users-container">
      <?php foreach ($listings as $listing): ?>
        <a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $listing['id'] ?>">
          <div class="user-field">
            <p>
              <?= $listing['name'] ?>
            </p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</main>