<?php

//Sample Database Connection Syntax for PHP and MySQL.



//Connect To Database



$hostname="localhost";

$username="lelandp";

$password="Waiakea2009";

$dbname="FoodBuddie";

$usertable="Users";



mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");

mysql_select_db($dbname);



# Check If Record Exists



$query = "SELECT * FROM $usertable";



$result = mysql_query($query);

echo 'number of Users: ' . mysql_num_rows($result);

if($result)

{

while($row = mysql_fetch_array($result))

{

$name = $row['username'];

echo "Name: ".$name."<br>";

}

}

?> 

<style type="text/css">
body {
  background-color: #fff;
}

</style>
