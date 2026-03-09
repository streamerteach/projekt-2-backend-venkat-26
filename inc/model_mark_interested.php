<?php
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $listing_id = $_GET['id'];
    $action = $_POST['action'];
    $user_id = $_SESSION['user_id'];

    if ($action === 'interested') {
        $stmt = $conn->prepare("INSERT IGNORE INTO users_interested (user_id_fk, listing_id_fk) VALUES (?, ?)");
        $stmt->execute([$user_id, $listing_id]);
    } elseif ($action === 'not_interested') {
        $stmt = $conn->prepare("DELETE FROM users_interested WHERE user_id_fk = ? AND listing_id_fk = ?");
        $stmt->execute([$user_id, $listing_id]);
    }

    header("Location: " . BASE_URL . "/index.php?page=listing&id=" . $listing_id);
    exit;
}
?>