<?php
//Detect if running locally or on server
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Auto-detect BASE_URL
works regardless of :
-username
-folder structure
-localhost vs cgi.arcada.fi

*/
//Example SCRIPT_NAME:
// /~battinav/backend/projekt1-backend-venkat26/home/index.php
//  /projekt1-backend-venkat26/home/index.php

$scriptname = $_SERVER['SCRIPT_NAME'];
$baseUrl = dirname($scriptname); //Just the folder containing index.php

$baseUrl =  rtrim($baseUrl, '/'); //remove trailing slash


define('BASE_URL', $baseUrl);

?>