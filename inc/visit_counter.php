<?php 
if(session_status() === PHP_SESSION_NONE){
  session_start();
}

//Path to the visit file
$visitDir = __DIR__ . '/../data';
$visitFile = __DIR__ . '/../data/visits.json';

//Make sure the data directory exists
if(!is_dir($visitDir)){
  mkdir($visitDir, 0755, true); //recursive mkdir
}
//Identify visitor (username if logged in, otherwise IP)
$visitorId = $_SESSION['username'] ?? $_SESSION['REMOTE_ADDR'] ?? 'UNKNOWN';

//Load existing visits
$visits = [];

if(file_exists($visitFile)){
  $json = file_get_contents($visitFile);
  $visits = json_decode($json, true) ?? [];
}

//Register unique Visitor
if(!isset($visits[$visitorId])){
  $visits[$visitorId] = date('Y-m-d, H:i');

  //Only attempt to write if file is writable
  if(is_writeable(dirname($visitDir) || !file_exists($visitFile))){
    file_put_contents(
      $visitFile, 
      json_encode($visits, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
     );
  } else {
      error_log("Can not write to visit file: $visitFile. Check Permissions. ");
  }

  
}

// Total unique Visitors
$totalUniqueVisits= count($visits);