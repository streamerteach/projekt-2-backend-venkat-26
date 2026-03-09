<?php
    $errors = [];
    $success = false;

    $stmt = $conn->prepare("
    SELECT 
        (SELECT 1 FROM users_interested WHERE user_id_fk = :user_id AND listing_id_fk = :listing_id) AS is_interested,
        (SELECT COUNT(*) FROM users_interested WHERE listing_id_fk = :listing_id) AS total_interested
    ");

    $stmt->execute([
        'user_id' => $_SESSION['user_id'], 
        'listing_id' => $_GET['id']
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $isInterested = (bool)$result['is_interested'];
    $totalInterested = $result['total_interested'];
?>