<?php
  $stmt = $conn->prepare("SELECT * FROM users ORDER BY username ASC");
  $stmt->execute();

  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="admin-page">
  <div class="admin-container">
    <h2>Select a User to Edit</h2>
    <div id="users-container">
      <?php foreach ($users as $user): ?>
        <a href="<?= BASE_URL ?>/index.php?page=user-admin&id=<?= $user['id'] ?>">
          <div class="user-field">
            <p>
              <?= $user['username'] ?>
            </p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</main>