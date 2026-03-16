<?php
session_start();
include_once __DIR__ . '/../inc/db.php';

if (empty($_SESSION['username'])) {
    header("Location: ../login/");
    exit();
}

$message = "";
$currentUsername = $_SESSION['username'];

// Fetch current user id
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
    die("User not found.");
}

if (isset($_POST['deleteProfile'])) {
    try {
        $conn->beginTransaction();

        $userId = (int)$user['id'];

        // 1. Delete comments on this user's listings
        $deleteListingComments = $conn->prepare("
            DELETE c
            FROM comments c
            INNER JOIN listings l ON c.listing_id_fk = l.id
            WHERE l.user_id_fk = :user_id
        ");
        $deleteListingComments->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteListingComments->execute();

        // 2. Delete this user's own comments
        $deleteOwnComments = $conn->prepare("
            DELETE FROM comments
            WHERE user_id_fk = :user_id
        ");
        $deleteOwnComments->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteOwnComments->execute();

        // 3. Delete interest rows connected to this user's listings
        $deleteListingInterest = $conn->prepare("
            DELETE ui
            FROM users_interested ui
            INNER JOIN listings l ON ui.listing_id_fk = l.id
            WHERE l.user_id_fk = :user_id
        ");
        $deleteListingInterest->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteListingInterest->execute();

        // 4. Delete this user's own interests
        $deleteOwnInterest = $conn->prepare("
            DELETE FROM users_interested
            WHERE user_id_fk = :user_id
        ");
        $deleteOwnInterest->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteOwnInterest->execute();

        // 5. Delete this user's listings
        $deleteListings = $conn->prepare("
            DELETE FROM listings
            WHERE user_id_fk = :user_id
        ");
        $deleteListings->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteListings->execute();

        // 6. Delete the user
        $deleteUser = $conn->prepare("
            DELETE FROM users
            WHERE id = :user_id
        ");
        $deleteUser->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteUser->execute();

        $conn->commit();

        session_unset();
        session_destroy();

        header("Location: ../index.php");
        exit();

    } catch (PDOException $e) {
        $conn->rollBack();
        $message = "Failed to remove profile: " . $e->getMessage();
    }
}
?>

<main class="">
    <div class="page-section">
        <h1>Remove Profile</h1><br>

        <p>
            Are you sure you want to remove your profile?
            This will also delete your listings, comments, and related data.
        </p><br>

        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p><br>
        <?php endif; ?>

        <form method="post" action="">
            <button type="submit" name="deleteProfile" class="manage-btn delete-btn">
                Yes, Delete My Profile
            </button>
            <a href="../index.php?page=profile/" class="manage-btn" style="text-decoration:none;">Cancel</a>
        </form>
    </div>
</main>