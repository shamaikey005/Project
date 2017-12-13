<?php 

  session_start();
  date_default_timezone_set('Asia/Bangkok');

  $server = "localhost";
  $port = "3306";
  $user = "root";
  $pass = "";
  $db = "pj01";

  try {
    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected!";
  } 
  catch(PDOException $e) {
    echo "Connection Error";
  }

  require_once('User.php');
  $user = new User($conn);

?>