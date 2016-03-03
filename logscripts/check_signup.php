<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('Connections/root.php');
$dbname="FoodBuddie";
mysql_select_db("$dbname")or die("cannot select DB");
?>
<?php
require_once('prep_Input.php');
foreach ($_POST as $key=>$value){
	$key = prep_Input($key);
	if($value==""){
		header("Location: http://www.foodbuddie.com/signup.php?error=1");
	}
}

if($_POST['password1'] != $_POST['password2']){
	header("Location: http://www.foodbuddie.com/signup.php?error=2");
	exit();
}
if(mysql_num_rows(mysql_query("SELECT * FROM Users WHERE username = '{$_POST['username']}'")) != 0){
	header("Location: http://www.foodbuddie.com/signup.php?error=3");
	exit();
}
if(mysql_num_rows(mysql_query("SELECT * FROM Users WHERE email = '{$_POST['email']}'")) != 0){
	header("Location: http://www.foodbuddie.com/signup.php?error=4");
	exit();
}

mysql_query("INSERT INTO Users (username, password, email) VALUES ('{$_POST['username']}', '{$_POST['password1']}', '{$_POST['email']}' )");

header("Location: http://www.foodbuddie.com/signup_success.php");
exit();
/*

$sql="SELECT * FROM Users WHERE username = '{$_POST['username']}'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
*/