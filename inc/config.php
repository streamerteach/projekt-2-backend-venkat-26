<?php
//Detect if running locally or on server
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // $_SESSION['user_id'] = 5; // TEMPORARY FOR TESTING - REMOVE WHEN LOGIN SYSTEM IS COMPLETE
}

//Auto detect project root folder
$projectFolderName =  'projekt-2-backend-venkat-26' ;

//Example SCRIPT_NAME:
// /~battinav/backend/projekt1-backend-venkat26/home/index.php
//  /projekt1-backend-venkat26/home/index.php

$scriptName = $_SERVER['SCRIPT_NAME'];
//Find position of the project folder in path
$pos = strpos($scriptName, $projectFolderName);

if($pos !== false){
    //keep everything up to the project folder
    $baseUrl = substr($scriptName, 0, $pos + strlen($projectFolderName));
} else{
    //Fallback: use dirname of script
    $baseUrl = dirname($scriptName);
}

$baseUrl =  rtrim($baseUrl, '/'); //remove trailing slash

define('BASE_URL', $baseUrl);

?>