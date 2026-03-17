
<?php require_once __DIR__ .  '/inc/config.php';
require_once __DIR__ .  '/handy_methods.php';
require_once __DIR__ .  '/LanguageChange.php';
require_once __DIR__ .  '/inc/db.php';

define('APP_STARTED', true);

//Include cookie  banner logic so variables exist
include __DIR__ . '/cookie_banner.php';

//routing
$page = $_GET['page'] ?? 'home';

$routes = [
 'home' => 'home/index.php',
 'login' => 'login/index.php',
  'register' => 'register/index.php',
  'products' => 'products/index.php',
  'profile' => 'profile/index.php',
  'profile-update' => 'profile/update_profile.php',
 'profile-remove' => 'profile/remove_profile.php',
  'report' => 'report/index.php',
  'new-listing' => 'new-listing/index.php',
  'listing' => 'listing/index.php',
  'admin' => 'admin/index.php',
  'user-admin' => 'user-admin/index.php'
];

$file = $routes[$page] ?? $routes['home'];
?>

<?php include 'inc/header.php'; ?>

<main class="main-content">
  <?php include $file; ?>
</main>

  <?php include 'inc/footer.php'?>