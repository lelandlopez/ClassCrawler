<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('Connections/root.php');
$dbname="FoodBuddie";
mysql_select_db("$dbname")or die("cannot select DB");
?>
<?php
foreach ($_POST as $key){
	//$key = prep_Input($key);
}

?
$sql="SELECT * FROM Users WHERE username = '{$_POST['inputEmail']}' AND password = '{$_POST['inputPassword']}'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count>=1)
{
	echo "yay it was found";
}
else 
{
	echo "nay it wasn't";
}
?>