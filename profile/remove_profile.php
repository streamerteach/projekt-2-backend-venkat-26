<?php

include_once __DIR__ . '/../inc/db.php';

if (empty($_SESSION['username'])) {
    header("Location: index.php?page=login");
    exit();
}

$message = "";
$currentUsername = $_SESSION['username'];

// Get logged in user
$stmt = $conn->prepare("
    SELECT id, username
    FROM users
    WHERE username = :username
    LIMIT 1
");
$stmt->bindParam(':username', $currentUsername, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $message = "User not found.";
}

if (isset($_POST['deleteProfile']) && $user) {
    try {
        $conn->beginTransaction();

        $userId = (int)$user['id'];

        // Get all listing ids owned by this user
        $listingStmt = $conn->prepare("
            SELECT id FROM listings WHERE user_id_fk = :user_id
        ");
        $listingStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $listingStmt->execute();
        $listingIds = $listingStmt->fetchAll(PDO::FETCH_COLUMN);

        // If user has listings, remove dependent rows first
        if (!empty($listingIds)) {
            $placeholders = implode(',', array_fill(0, count($listingIds), '?'));

            // Delete comments on user's listings
            $deleteCommentsOnListings = $conn->prepare("
                DELETE FROM comments
                WHERE listing_id_fk IN ($placeholders)
            ");
            $deleteCommentsOnListings->execute($listingIds);

            // Delete users_interested rows on user's listings
            $deleteInterestedOnListings = $conn->prepare("
                DELETE FROM users_interested
                WHERE listing_id_fk IN ($placeholders)
            ");
            $deleteInterestedOnListings->execute($listingIds);
        }

        // Delete user's own comments
        $deleteOwnComments = $conn->prepare("
            DELETE FROM comments
            WHERE user_id_fk = :user_id
        ");
        $deleteOwnComments->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteOwnComments->execute();

        // Delete user's own interest rows
        $deleteOwnInterested = $conn->prepare("
            DELETE FROM users_interested
            WHERE user_id_fk = :user_id
        ");
        $deleteOwnInterested->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteOwnInterested->execute();

        // Delete user's listings
        $deleteListings = $conn->prepare("
            DELETE FROM listings
            WHERE user_id_fk = :user_id
        ");
        $deleteListings->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteListings->execute();

        // Delete user
        $deleteUser = $conn->prepare("
            DELETE FROM users
            WHERE id = :user_id
        ");
        $deleteUser->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteUser->execute();

        $conn->commit();

        session_unset();
        session_destroy();

        header("Location: index.php?page=home");
        exit();

    } catch (PDOException $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        $message = "Delete failed: " . $e->getMessage();
    }
}
?>

<div class="page-section">
    <h1>Remove Profile</h1><br>

    <p>Are you sure you want to delete your profile? This cannot be undone.</p><br>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p><br>
    <?php endif; ?>

    <form method="post" action="">
        <button type="submit" name="deleteProfile" class="manage-btn delete-btn">
            Yes, Delete My Profile
        </button>

        <a href="index.php?page=profile" class="manage-btn">Cancel</a>
    </form>
</div>