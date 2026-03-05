<?php 
//database config

//Detect if running locally or on arcada server
if(strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
  $host = 'localhost';
  $db = 'reuse_market';
  $user = 'root'; //default XAMPP user
  $pass = ''; //default XAMPP password is empty
  
} else {
  //Arcada server - replace with your credentials
  $host = 'localhost';
  $db = 'reuse_market'; //your arcada database name
  $user = 'battinav'; //your arcada db username
  $pass = 'your_arcada_password'; 
  
}

$charset = 'utf8mb4';
 
 //DSN string
 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

 //Options for PDO
 $options = [
 PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
 PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
 PDO::ATTR_EMULATE_PREPARES    => false,
 ];
 
 try{
  $pdo = new PDO($dsn, $user, $pass, $options);
 } catch(PDOException $e) {
  die("Database connection failed :" . $e->getMessage());
 }
?>