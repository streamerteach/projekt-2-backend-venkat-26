<?php
    if (! defined('APP_STARTED')) {exit;}
    //Start the session
    if(session_status() === PHP_SESSION_NONE){
      session_start();
    }
    $errors  = [];
    $success = false;

    // Logout handler
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location:' . BASE_URL . '/index.php?page=login');
    exit;
    }

    //Includes database connection
    require_once __DIR__  . '/../inc/db.php'; 
    // CSRF token (optional)
    if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    //Hardcoded test account
    if (!isset($_SESSION['users'])) {
    $_SESSION['users']   = [];
    $_SESSION['users'][] = [
        'username' => 'testuser',
        'email'    => 'test@example.com',
        'password' => password_hash('Test1234', PASSWORD_DEFAULT),
    ];
    }
    

    // Handle POST login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf     = $_POST['csrf_token'] ?? '';

    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $errors[] = 'Invalid form submission';
    }

    // Validation
    if ($email === '' || $password === '') {
        $errors[] = 'Both fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }
    // Check credentials using existing $conn
    if (empty($errors)) {
      $stmt = $conn->prepare("
        SELECT 
          u.id, 
          u.username, 
          u.passhash, 
          r.role_level 
        FROM users u
        INNER JOIN roles r ON u.role_id_fk = r.id
        WHERE u.email = :email 
        LIMIT 1");
      $stmt->execute(['email' => $email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && password_verify($password, $user['passhash'])) {
                  //Set session 
                    $_SESSION['user_id']  = $user['id']; 
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role_level'] = $user['role_level'];
                    $success              = true;

                    //Redirect to target page
                    $allowed_pages = ['products', 'profile'];
                    $redirect = $_GET['redirect'] ?? 'products';
                    if(!in_array($redirect, $allowed_pages)) {
                      $redirect = 'products' ;
                    }
                    $redirect_url = BASE_URL . "/index.php?page=$redirect";
                    
                    header("Location: $redirect_url" );
                    exit;
                } else {
                $errors[] = 'Incorrect email or password';
                }
           } 
    }
    
?>

<main class="login-page">
  <div class="login-container">
    <?php if (!empty($_SESSION['user_id'])): ?>
      <h2>Do you want to log out, "<?php echo htmlspecialchars($_SESSION['username'] ?? '') ?>"?</h2>
      <a href="<?php echo BASE_URL ?>/index.php?page=login&action=logout" class="btn-logout" onclick="return confirm('Are you sure you want to log out?');">Logout</a>
    <?php else: ?>
      <h2>Login to ReUse Market</h2>

      <?php if ( !empty($errors)): ?>
        <div class="error-messages">
          <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error) ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?php echo BASE_URL ?>/index.php?page=login" method="POST" class="form">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn-login">Login</button>
      </form>

      <div class="extra-links">
        <a href="#">Forgot password</a><br>
        <a href="<?php echo BASE_URL ?>/index.php?page=register">Sign Up</a>
      </div>
    <?php endif; ?>
  </div>
</main>
