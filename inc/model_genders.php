<?php
    $sql = "SELECT * FROM genders";
    $stmt = $conn->query($sql);
    $genders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>