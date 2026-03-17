<?php
include_once __DIR__ . '/../inc/db.php';

if (empty($_SESSION['username'])) {
    header("Location: ../login/");
    exit();
}

$message = "";
$currentUsername = $_SESSION['username'];

// Fetch current user
$stmt = $conn->prepare("
    SELECT id, username, realname, email, city, bio, gender_id_fk, img_path
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

// Fetch genders for dropdown
$genderStmt = $conn->prepare("SELECT id, name FROM genders ORDER BY id ASC");
$genderStmt->execute();
$genders = $genderStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submit
if (isset($_POST['updateProfile'])) {
    $newUsername = trim($_POST['username'] ?? '');
    $newRealname = trim($_POST['realname'] ?? '');
    $newEmail    = trim($_POST['email'] ?? '');
    $newCity     = trim($_POST['city'] ?? '');
    $newBio      = trim($_POST['bio'] ?? '');
    $newGender   = (int)($_POST['gender_id_fk'] ?? 0);
    $newPassword = trim($_POST['password'] ?? '');

    if (
        empty($newUsername) ||
        empty($newRealname) ||
        empty($newEmail) ||
        empty($newCity) ||
        empty($newBio) ||
        empty($newGender)
    ) {
        $message = "Please fill in all required fields.";
    } else {
        try {
            // Check if username is already used by another user
            $checkStmt = $conn->prepare("
                SELECT id
                FROM users
                WHERE username = :username AND id != :id
                LIMIT 1
            ");
            $checkStmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
            $checkStmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
            $checkStmt->execute();

            if ($checkStmt->fetch()) {
                $message = "That username is already taken.";
            } else {
                if (!empty($newPassword)) {
                    $newPasshash = password_hash($newPassword, PASSWORD_DEFAULT);

                    $updateStmt = $conn->prepare("
                        UPDATE users
                        SET username = :username,
                            realname = :realname,
                            passhash = :passhash,
                            email = :email,
                            city = :city,
                            bio = :bio,
                            gender_id_fk = :gender_id_fk
                        WHERE id = :id
                    ");

                    $updateStmt->bindParam(':passhash', $newPasshash, PDO::PARAM_STR);
                } else {
                    $updateStmt = $conn->prepare("
                        UPDATE users
                        SET username = :username,
                            realname = :realname,
                            email = :email,
                            city = :city,
                            bio = :bio,
                            gender_id_fk = :gender_id_fk
                        WHERE id = :id
                    ");
                }

                $updateStmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
                $updateStmt->bindParam(':realname', $newRealname, PDO::PARAM_STR);
                $updateStmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
                $updateStmt->bindParam(':city', $newCity, PDO::PARAM_STR);
                $updateStmt->bindParam(':bio', $newBio, PDO::PARAM_STR);
                $updateStmt->bindParam(':gender_id_fk', $newGender, PDO::PARAM_INT);
                $updateStmt->bindParam(':id', $user['id'], PDO::PARAM_INT);

                $updateStmt->execute();

                $_SESSION['username'] = $newUsername;

                // Refresh displayed user data
                $user['username'] = $newUsername;
                $user['realname'] = $newRealname;
                $user['email'] = $newEmail;
                $user['city'] = $newCity;
                $user['bio'] = $newBio;
                $user['gender_id_fk'] = $newGender;

                $message = "Profile updated successfully.";
            }
        } catch (PDOException $e) {
            $message = "Update failed: " . $e->getMessage();
        }
    }
}
?>
   <main class="">
    <div class="page-section">
      <h1>Update Profile</h1> <br>
      <?php if (! empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p> <br>
        <?php endif; ?>
        <form method="post" action="">
          <label for="username">Username</label> <br>
          <input type="text" id="username " name="username" value="<?php echo htmlspecialchars($user['username']); ?>"  required > <br> <br>

          <label for="realname">Real Name</label> <br>
          <input type="text" id="realname " name="realname" value="<?php echo htmlspecialchars($user['realname']); ?>"  required > <br> <br>

          <label for="email"> Email</label> <br>
          <input type="email" id="email " name="email" value="<?php echo htmlspecialchars($user['email']); ?>"  required > <br> <br>

          <label for="city"> City / Postal Code</label> <br>
          <input type="text" id="city " name="city" value="<?php echo htmlspecialchars($user['city']); ?>"  required > <br> <br>

          <label for="bio"> Bio </label> <br>
          <textarea id="bio"  name="bio"  rows="4" cols="40" required> <?php echo htmlspecialchars($user['bio']); ?> </textarea><br><br>

          <label for="gender_id_fk"> Gender</label>
           <select name="gender_id_fk" id="gender_id_fk" required>
                <option value="">Select gender</option>
                <?php foreach ($genders as $gender): ?>
                    <option
                        value="<?php echo (int)$gender['id']; ?>"
                        <?php echo ((int)$user['gender_id_fk'] === (int)$gender['id']) ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($gender['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
        <label for="password">New Password</label><br>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Leave blank to keep current password"
            ><br><br>

            <button type="submit" name="updateProfile" class="manage-btn">Save Changes</button>
            <a href="index.php?page=profile/
            " class="manage-btn" style="text-decoration:none;">Cancel</a>
        </form>
    </div>
   </main>
