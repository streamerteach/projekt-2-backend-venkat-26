<?php

$orderBy = "date_added DESC"; 

if (isset($_POST['sort'])) {
    switch ($_POST['sort']) {
        case 'price_asc':
            $orderBy = "price ASC";
            break;
        case 'price_desc':
            $orderBy = "price DESC";
            break;
        case 'oldest':
            $orderBy = "price ASC";
            break;
        case 'newest':
        default:
            $orderBy = "date_added DESC";
            break;
    }
}

$stmt = $conn->prepare("SELECT * FROM listings ORDER BY $orderBy");
$stmt->execute();

$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);