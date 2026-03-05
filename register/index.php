<?php
if (!defined('APP_STARTED')) {
    exit;
}

$errors  = [];
$success = false;

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation
    if ($username === '' || $email === '' || $password === '') {
        $errors[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    // Initialize offline users in session if not set
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }

    // Check if username or email already exists
    foreach ($_SESSION['users'] as $user) {
        if ($user['username'] === $username || $user['email'] === $email) {
            $errors[] = 'Username or email already exists.';
            break;
        }
    }

    // If no errors, store in session
    if (empty($errors)) {
        $_SESSION['users'][] = [
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $success = true;

        //send an email with a random password
        $password = bin2hex(random_bytes(8));

        $msg = "Thank you for registering to use ReUse Market!\nHere is your randomly generated password: " . $password;

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);
        
        mail($email,"You have registered to use ReUse Market",$msg);
    }
}
?>

<main class="register-page">
  <div class="register-container">
    <h2>Register to ReUse Market 🌱</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert success">
        <p>Account created successfully! 🥳</p>
        <p><a href="<?= BASE_URL ?>/index.php?page=login">Login here</a></p>
      </div>
    <?php else: ?>
      <form action="<?= BASE_URL ?>/index.php?page=register" method="POST" class="form">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn-register">Register</button>
      </form>
      <div class="extra-links">
        <a href="<?= BASE_URL ?>/index.php?page=login">Already have an account?</a><br>
        <a href="#">Forgot password</a>
      </div>
    <?php endif; ?>
  </div>
</main>
