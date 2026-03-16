<?php
    $sql = "SELECT * FROM roles";
    $stmt = $conn->query($sql);
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>