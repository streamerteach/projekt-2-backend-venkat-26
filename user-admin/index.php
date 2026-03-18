<?php
if($_SESSION['role_level'] < 200) {
  header("Location: " . BASE_URL . "/index.php?page=home");
  exit;
}

include __DIR__ . "/../inc/model_genders.php";
include __DIR__ . "/../inc/model_roles.php";

$errors  = [];
$success = false;

$user_id = $_GET['id'];
$user_found = false;
  
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
if ($stmt->execute([$user_id])) {
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if ($user) {
      $user_found = true;
  }
  
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {

    $username = trim($_REQUEST['username'] ?? '');
    $realname = trim($_REQUEST['realname'] ?? '');
    $email = trim($_REQUEST['email'] ?? '');
    $city = trim($_REQUEST['city'] ?? '');
    $bio = trim($_REQUEST['bio'] ?? '');
    $gender = trim($_REQUEST['gender'] ?? '');
    $role = trim($_REQUEST['role'] ?? '');

    $newpass = $_POST['newpass'] ?? '';
    $newpassrepeat = $_POST['newpassrepeat'] ?? '';

    // Validation
    if ($username === '' or $realname === '' or $email === '' or $city === '' or $bio === '' or $gender === '' or $role === '') {
        $errors[] = 'All fields with * are required.';
    } elseif (strlen($username) < 6) {
        $errors[] = 'Username must be at least 6 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } 

    // Validate password update
    if (!empty($newpass) and empty($newpassrepeat) or empty($newpass) and !empty($newpassrepeat)) {
        $errors[] = 'You must fill both password fields to update password';
    } elseif (!empty($newpass) and !empty($newpassrepeat) and $newpass !== $newpassrepeat) {
        $errors[] = 'Repeated password did not match new password';
    } elseif (!empty($newpass) and !empty($newpassrepeat) and $newpass === $newpassrepeat) {
        if (strlen($newpass) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        } else {
            $password = $newpass;
        }
    }

    $username = sanitize_input($username);
    $realname = sanitize_input($realname);
    $email = sanitize_input($email);
    $city = sanitize_input($city);
    $bio = sanitize_input($bio);
    $gender = sanitize_input($gender);
    $role = sanitize_input($role);

    if (isset($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Check if email already exists in db
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$username, $email, $user_id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errors[] = 'Username or email is already taken.';
    }

    if (empty($errors)) {
    
        $fields = [
            "username = :username",
            "realname = :realname",
            "email = :email",
            "city = :city",
            "bio = :bio",
            "gender_id_fk = :gender",
            "role_id_fk = :role"
        ];
        
        $params = [
            ':id'       => $user_id,
            ':username' => $username,
            ':realname' => $realname,
            ':email'    => $email,
            ':city'     => $city,
            ':bio'      => $bio,
            ':gender'   => $gender,
            ':role'     => $role
        ];

        // Set new password if set
        if (isset($hashed_password)) {
            $fields[] = "passhash = :passhash";
            $params[':passhash'] = $hashed_password;
        }

        // Construct the query
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";

        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute($params)) {
            $success = true;
        } else {
            $errors[] = 'Failed to update user. Please try again.';
        }
    }
}

$delete_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['delete_user'])) {

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$user_id])) {
        $delete_success = true;
    } else {
        $errors[] = "Could not delete user.";
    }
}
?>

<main class="admin-page">

  <div class="admin-container">
    <p><a class="btn-blue" href="<?= BASE_URL ?>/index.php?page=user-listings-admin&id=<?= $user_id ?>">View user listings</a></p>
  </div>

<?php if ($_SESSION['role_level'] >= 300): ?>
  <div class="admin-container">
    <?php if (!$user_found): ?>
      <div class="alert error">
        <p>User was not found. Either the user has been deleted or user ID is incorrect.</p>
        <p><a href="<?= BASE_URL ?>/index.php?page=admin">To admin page</a></p>
      </div>
    <?php else: ?>

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert success">
        <p>Account updated successfully! 🥳</p>
        <p><a href="<?= BASE_URL ?>/index.php?page=user-admin&id=<?= $user_id ?>">Show updated user data</a></p>
      </div>

    <?php elseif ($delete_success): ?>
      <div class="alert success">
        <p>Account successfully deleted!</p>
        <p><a href="<?= BASE_URL ?>/index.php?page=admin">To admin page</a></p>
      </div>
    <?php else: ?>
      <form action="<?= BASE_URL ?>/index.php?page=user-admin&id=<?= $user_id ?>" method="POST" class="form">
        

        <div class="form-group">
          <label for="username">Username*</label>
          <input type="text" name="username" placeholder="Enter your username" required value="<?= $user['username'] ?>">
        </div>

        <div class="form-group">
          <label for="email">Email*</label>
          <input type="email" name="email" placeholder="Enter your email" required value="<?= $user['email'] ?>">
        </div>

        <div class="form-group">
          <label for="realname">Real name*</label>
          <input type="text" name="realname" placeholder="Enter your real name" required value="<?= $user['realname'] ?>">
        </div>

        <div class="form-group">
          <label for="city">City*</label>
          <input type="text" name="city" placeholder="Enter your city" required value="<?= $user['city'] ?>">
        </div>

        <div class="form-group">
          <label for="bio">Bio*</label>
          <input type="text" name="bio" placeholder="Enter a short bio" required value="<?= $user['bio'] ?>">
        </div>

        <div class="form-group">
          <label for="gender">Gender*</label>
          <select name="gender">
            <option value="" disabled selected hidden>Please select</option>
            
            <?php foreach ($genders as $gender): ?>
              <option value="<?= htmlspecialchars($gender['id']) ?>" <?php if($user['gender_id_fk'] === $gender['id']) echo " selected"; ?>>
                <?= htmlspecialchars($gender['name']) ?>
              </option>
            <?php endforeach; ?>
      
          </select>
        </div>

        <div class="form-group">
          <label for="role">Role*</label>
          <select name="role">
            <option value="" disabled selected hidden>Please select</option>
            
            <?php foreach ($roles as $role): ?>
              <option value="<?= htmlspecialchars($role['id']) ?>" <?php if($user['role_id_fk'] === $role['id']) echo " selected"; ?>>
                <?= htmlspecialchars($role['role_name']) ?>
              </option>
            <?php endforeach; ?>
      
          </select>
        </div>

        <div class="form-group">
          <label for="newpass">New password</label>
          <input type="password" name="newpass" placeholder="Enter a new password">
        </div>

        <div class="form-group">
          <label for="newpassrepeat">Repeat new password</label>
          <input type="password" name="newpassrepeat" placeholder="Repeat the new password">
        </div>

        <button type="submit" name="update_user" class="btn-register">Update user data</button>
      </form>
    
  </div>

  <div class="admin-container delete-user">
    <form method="POST" action="">
      <button class="btn-delete" type="submit" name="delete_user" onclick="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.');">
          Delete User
      </button>
    </form>
  </div>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>
</main>