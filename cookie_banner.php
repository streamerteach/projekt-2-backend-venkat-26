<?php
    //Initialize message variable
    $cookie_message = '';
    $show_cookie_banner    = false;

    //handle cookie consent
    if (isset($_POST['accept_cookies'])) {
    setcookie('cookie_consent', 'accepted', time() + 31536000, "/");
    header("Location:" . $_SERVER['PHP_SELF']);
    exit;
    }

    if (isset($_POST['reject_cookies'])) {
    setcookie('cookie_consent', 'rejected', time() + 31536000, "/");
    header("Location:" . $_SERVER['PHP_SELF']);
    exit;
    }

    //Get existing cookie consent
    $cookieConsent = $_COOKIE['cookie_consent'] ?? null;

    //Handle username cookie (only if consent given)
    $username = $_SERVER['REMOTE_USER'] ?? null;
    //Om användaren logged in via server auth
    if ($cookieConsent === 'accepted' && $username !== null) {
    //Sätta cookie
    setcookie('username', $username, time() + (86400 * 30), "/");
    }

    //User greeting message(used in page)
  if (isset($_COOKIE['username'])) {
    $cookie_message = "Välkommen tillbaka <strong>" . htmlspecialchars($_COOKIE['username']) . "</strong > 👋";
    } elseif ($username !== null) {
    $cookie_message = "Välkommen <strong>" . htmlspecialchars($username) . "</strong > 👋 ";
    } 
 //---Show consent banner if needed ---
    $show_cookie_banner = ! $cookieConsent;
// if (! $cookieConsent):
 ?>

