<?php

$errors = [];
$success = false;
$upload_successful = false;
$target_file = null;
$allowed_extensions = ['jpg', 'jpeg', 'png'];
$listing_id;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_REQUEST['name'] ?? '');
    $description = trim($_REQUEST['description'] ?? '');
    $price = trim($_REQUEST['price'] ?? '');

    // Initial validation
    if ($name === '' or $description === '' or $price === '' or !isset($_FILES["listing_img"])) {
        $errors[] = 'All fields are required.';
    } elseif (strlen($name) < 6) {
        $errors[] = 'Listing name must be at least 6 characters.';
    } elseif (strlen($description) < 6) {
        $errors[] = 'Description must be at least 6 characters.';
    } elseif (filter_var($price, FILTER_VALIDATE_FLOAT) === false) {
        $errors[] = 'Price must be entered as a valid number.';
    }

    // Image upload
    if (empty($errors)) {
        if ($_FILES["listing_img"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/../images/";
            $tmp_path = $_FILES["listing_img"]["tmp_name"];
            $extension = strtolower(pathinfo($_FILES["listing_img"]["name"], PATHINFO_EXTENSION));
            $check = getimagesize($tmp_path);
            echo $extension;

            if ($check === false) {
                $errors[] = "The uploaded file is not a valid image.";
            } elseif (!in_array($extension, $allowed_extensions)) {
                $errors[] = "Only JPG and PNG images are allowed.";
            } else {
                $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
                $target_file = $target_dir . $safeName;

                if ($_FILES["listing_img"]["size"] > 1048576) {
                    $errors[] = "Sorry, your file is too large.";
                } elseif (!move_uploaded_file($tmp_path, $target_file)) {
                    $errors[] = "Sorry, there was an error uploading your file.";
                } else {
                    $upload_successful = true;
                }
            }
        } else {
            $errors[] = "File upload failed with error code: " . $_FILES["listing_img"]["error"];
        }
    }

    // Database insertion
    if (empty($errors) && $upload_successful) {
        
        $name = sanitize_input($name);
        $description = sanitize_input($description);
        $price = sanitize_input($price);

        $sql = "INSERT INTO `listings` (`name`, `description`, `price`, `user_id_fk`, `date_added`, `img_path`) 
                VALUES (:listing_name, :listing_description, :price, :user_id, CURRENT_TIMESTAMP, :img_path)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':listing_name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':listing_description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':img_path', $safeName, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $success = true;
            $listing_id = $conn->lastInsertId();
        } else {
            $errors[] = 'An error occurred when inserting into database.';
        }
    }
}

?>