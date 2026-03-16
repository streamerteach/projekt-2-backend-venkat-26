<?php
    if(!defined('APP_STARTED')) exit;
    include __DIR__ . '/../cookie_banner.php';
    include __DIR__ . '/../inc/visit_counter.php';
//---First -Time VISIT tracking
$firstVisit = false;
$firstVisitDate = null;

//Only track first visit if functional cookies are allowed
if(!isset($cookieConsent) || $cookieConsent !== 'rejected'){
  if(!isset($_COOKIE['first_visit'])){
    $firstVisit = true;
    $firstVisitDate =date('d F Y, H:i');
    setcookie('first_visit', $firstVisitDate, time() +(10*365*24*60*60), "/");
  } else {
    $firstVisitDate = $_COOKIE['first_visit'];
  }

  //Last visit tracking
  $lastVisitDate = $_COOKIE['last_visit'] ?? null; //get last visit from cookie
  $currentVisit = date('d F Y, H:i');
  setcookie('last_visit', $currentVisit, time() + (10*365*25*60*60), "/");
}
?>
 <div class="page-section user-info">
      <?php if($cookie_message): ?>
      <p><?php echo $cookie_message; ?> </p>
      <?php endif; ?>
      
  <!--User info -->
  <h>Hello <strong> <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?> </strong></h>

  <p>Status: <strong> <?php echo isset($_SESSION['username']) ? 'Logged in' : 'Guest user' ;?> </strong> </p>

  <p> Language: <strong> <?php echo strtoupper($_SESSION['lang'] ?? 'EN'); ?> </strong> </p>

  <p>We are running on <?php echo ' PHP Version' . phpversion(); ?> </p>
  <p>Apache Version: <?= htmlspecialchars(apache_get_version() ?? 'Not available') ?></p>

  <p>
    Unique visitors so far:
    <strong><?=  $totalUniqueVisits ?> </strong>
  </p>

  <?php if($firstVisit): ?>
    <p>Welcome! This is your first visit today.</p>
    <?php elseif ($firstVisitDate): ?>
      <p> First visit ever: <?=  htmlspecialchars($firstVisitDate); ?></p>
      <?php endif;?>

      <?php if (!empty($lastVisitDate)): ?>
        <p>Last visit: <?= htmlspecialchars($lastVisitDate); ?></p>
    <?php endif; ?>
    </div>

<!-- Intro Section -->
 <div class="page-section intro-section">
<article class="intro">
 <h1>Welcome to the ReUse Market</h1>
  <!-- /* <p>Välkommen till vår second hand-butik</p> */ -->
 <ul>
  <li>Buy & sell second-hand items easily</li>
  <li>Save money and planet 🌱🌱 </li>
</ul>
 </article>
</div>

 <!-- Cookie / Extra message -->
<div class="page-section message-section">
<article class="message">
   <p>Thousands of listings coming soon!</p>
 </article>
</div>

<div class="page-section">
    <article class="message">
      <p><?php
        echo 'Today is ' . date('l') . ' the ' . date('j F') . ', week ' . (int)date('W');
      ?></p>

      <h2>Create time-limited listing:</h2><br>
      <form method="POST" action="<?php echo BASE_URL;?>/index.php?page=home">
        <?php $now = date('Y-m-d\TH:i'); ?>
        <input type="datetime-local" name="delisting_date" min="<?php echo $now; ?>" required>
        <button type="submit">Create time-limited listing</button><br><br>
      </form>
      <p id="countdown"></p>
    </article>
</div>

<!-- Cookie banner -->
<?php if($show_cookie_banner) :?>
<form method="post" class="cookie-banner" action="<?php echo BASE_URL; ?>/index.php?page=home">
 <p>Vi använder endast funktionella kakor.</p>
 <button name="accept_cookies">Acceptera</button>
 <button name="reject_cookies">Avböj</button>
</form>
<?php endif; ?>


<?php
date_default_timezone_set("Europe/Helsinki");
if (!empty($_REQUEST['delisting_date'])) {
    $date = $_REQUEST['delisting_date'];
    $date = trim($date);
    $date = stripslashes($date);
    $date = htmlspecialchars($date);
    
    $delistingTimestamp = strtotime($date) * 1000;
}
?>

<script>
  const display = document.getElementById("countdown");
  const delistingDate = <?php echo $delistingTimestamp; ?>;

  if(delistingDate > 0){
    const timeInterval = setInterval(() => {
       const now = new Date().getTime();
       const distance = delistingDate - now ;
       if(distance < 0){
        clearInterval(timeInterval) ;
        display.innerHTML = 'Listing HAS BEEN DELISTED' ;
       } else {
        const days = Math.floor(distance/(1000*60*60*24));
        const hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60)) ;
        const minutes = Math.floor((distance %(1000*60*60)) / (1000*60)) ;
        const seconds = Math.floor((distance  % (1000*60)) / 1000) ;
        display.innerHTML = `Time until delisting : ${days}d ${hours}h  ${minutes}m ${seconds}s` ;
       }
    },1000);
  } else {
display.innerHTML = "Please enter a future date and time.";
  }
</script>