
<?php

$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_REQUEST['username'] ?? '');
    $realname = trim($_REQUEST['realname'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_REQUEST['email'] ?? '');
    $city = trim($_REQUEST['city'] ?? '');
    $bio = trim($_REQUEST['bio'] ?? '');
    $gender = trim($_REQUEST['gender'] ?? '');

    // Validation
    if ($username === '' or $realname === '' or $password === '' or $email === '' or $city === '' or $bio === '' or $gender === '') {
        $errors[] = 'All fields are required.';
    } elseif (strlen($username) < 6) {
        $errors[] = 'Username must be at least 6 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    $username = sanitize_input($username);
    $realname = sanitize_input($realname);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $email = sanitize_input($email);
    $city = sanitize_input($city);
    $bio = sanitize_input($bio);
    $gender = sanitize_input($gender);


    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errors[] = 'Username or email is already taken.';
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `users` (`username`, `realname`, `passhash`, `email`, `city`, `bio`, `gender_id_fk`, `role_id_fk`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$username, $realname, $hashed_password, $email, $city, $bio, $gender, '4'])) {
            $success = true;
        }
    }
    
        
    //print("<p>Hashed password stored in DB:".$hashed_password."</p>");


    // Verifiera inmatat lösneord med hash från DB
    /*if(!empty($_REQUEST['password'])){
        
        $sql = "SELECT * FROM profiles where username = ?";
        $result = $conn->prepare($sql);
        $result->execute([$username]);
        // Fetch a row
        $row = $result->fetch();
        //print_r($row['passhash']);
        // Hämta passhash från den assosiativa arrayen 
        $hashFromDB = $row['passhash'];
        print("<p>Hittade följande passhash från DB:n: ".$hashFromDB."</p>");

        if (password_verify($_REQUEST['password'], $hashFromDB)) {
            print("<p>Password matches hash from DB</p>");
            $_SESSION['username'] = sanitize_input($_REQUEST['username']);
            
            
        } else {
            print("<p>Password doesn't match hash</p>");
        }
    }*/
}

?>