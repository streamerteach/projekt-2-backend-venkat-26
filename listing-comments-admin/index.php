<?php
if($_SESSION['role_level'] < 200) {
  header("Location: " . BASE_URL . "/index.php?page=home");
  exit;
}

$listing_id = $_GET['id'];
$user_found = false;
$errors  = [];
$success = false;
  
$stmt = $conn->prepare("SELECT * FROM comments WHERE listing_id_fk = ?");
if ($stmt->execute([$listing_id])) {
  $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if ($comments) {
      $user_found = true;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['delete_comment'])) {
  $comment_id = $_POST['delete_comment'];

  $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
  if ($stmt->execute([$comment_id])) {
      $success = true;
  } else {
      $errors[] = "Could not delete comment.";
  }
}
?>

<main class="admin-page">
  

  <div class="admin-container">
    <?php if ($success): ?>
        <div class="alert success">
          <p>Listing deleted successfully!</p>
          <p><a href="<?= BASE_URL ?>/index.php?page=listing-comments-admin&id=<?= $listing_id ?>">Update list</a></p>
        </div>
    <?php endif; ?>  

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2>All listing comments</h2>
    <div id="users-container">
      <?php foreach ($comments as $comment): ?>
        <a href="<?= BASE_URL ?>/index.php?page=listing&id=<?= $_GET['id'] ?>">
          <div class="user-field flex-row">
            <p>
              <?= $comment['content'] ?>
            </p>
            <form method="POST" action="">
              <button class="btn-delete width-auto" type="submit" name="delete_comment" value="<?=$comment['id']?>" onclick="return confirm('Are you sure you want to permanently delete this comment? This action cannot be undone.');">
                  Delete
              </button>
            </form>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</main>