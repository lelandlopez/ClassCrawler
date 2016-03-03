<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');
if(!isset($_SESSION['logged_in'])){
  header("Location: foodbuddie.com");
}

if(!isset($_GET['crn']) || !isset($_GET['university'])){
  header("Location: foodbuddie.com.php");
}

$dbname="ClassScraper";
mysql_select_db("$dbname")or die("cannot select DB");

$sql="DELETE FROM Watches WHERE user_id = '{$_SESSION['user_id']}' AND university_id = '{$_GET['university']}' AND crn = '{$_GET['crn']}'";
mysql_query($sql);

header("Location: view_watched_classes.php");


?>

