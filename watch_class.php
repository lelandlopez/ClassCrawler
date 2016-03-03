<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');
if(!isset($_SESSION['logged_in'])){
  header("Location: foodbuddie.com");
}

if(!isset($_GET['university_id']) || !isset($_GET['crn'])){
  header("Location: foodbuddie.com/find_a_class.php");
}

$dbname="ClassScraper";
mysql_select_db("$dbname")or die("cannot select DB");
$sql="SELECT * FROM Watches WHERE user_id = '{$_SESSION['user_id']}' AND crn = '{$_GET['crn']}' AND university_id = '{$_GET['university_id']}'";
$result=mysql_query($sql);
if(mysql_num_rows($result) == 0){
  mysql_query("INSERT INTO Watches (user_id, crn, university_id) VALUES ('{$_SESSION['user_id']}', '{$_GET['crn']}', '{$_GET['university_id']}')");
  header("Location: http://foodbuddie.com/view_watched_classes.php");
} else {
  header("Location: http://foodbuddie.com/view_watched_classes.php");
}



?>

