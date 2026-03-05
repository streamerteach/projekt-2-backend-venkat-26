<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/style.css">
  <title>ReUse Market</title>
</head>
<body>
 
 <header class="site-header">
      <div class="container">
        <!-- Logo -->
        <a href="<?php echo BASE_URL; ?>/index.php?page=home" class="logo">
  <img src="<?php echo BASE_URL?>/images/reuse.png" alt="ReUse Market Logo" />
        </a>

        <div class="right-items">
          <nav class="main-nav">
            <ul>
              <li>
                <a
                  href="<?php echo BASE_URL; ?>/index.php?page=home"
                  >Home</a
                >
              </li>
              <li>
                <a
                  href="<?php echo BASE_URL; ?>/index.php?page=products"
                  >Products</a
                >
              </li>
              <li>
                <a
                  href="<?php echo BASE_URL; ?>/index.php?page=login" >Login</a
                >
              </li>
              <li>
                <a
                  href="<?php echo BASE_URL; ?>/index.php?page=register"
                  
                  >Register</a
                >
              </li>
              
              <?php if (!empty($_SESSION['username'])) :?>
                <li>
                  <a
                    href="<?php echo BASE_URL; ?>/index.php?page=profile"
                    
                    >Profile</a
                  >
                </li>
              <?php endif; ?>

              <li>
                <a
                  href="<?php echo BASE_URL; ?>/index.php?page=report"
                  
                  >Reflective Reporting</a
                >
              </li>
              
            </ul>
          </nav>
          <?php 
           $languages = ['English', 'Svenska', 'Suomi' ] ;
          ?>
          <div class="language-selector">
            <button class="lang-btn" id="langToggle" title="Select language">
              🌍<span>EN</span>▼
            </button>
            <div class="lang-menu" id="langMenu">
              <a href="?lang=en">English</a>
              <a href="?lang=sv">Svenska</a>
              <a href="?lang=fi">Suomi</a>
            </div>
          </div>
        </div>
      </div>
    </header>
 