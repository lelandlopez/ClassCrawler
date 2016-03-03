<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');

$dbname="ClassScraper";
mysql_select_db("$dbname")or die("cannot select DB");

//makes sure it updates all
$sql="UPDATE Majors SET updated_recently = '0'";
$result=mysql_query($sql);

//grabing watches
$sql="SELECT user_id, class_id FROM Watches";
$result=mysql_query($sql);
//go through watches
while($row = mysql_fetch_array($result)){
	$sql = "SELECT * FROM Classes WHERE class_id = '{$row['class_id']}'";
	$classresult = mysql_query($sql);
	$classrow = mysql_fetch_array($classresult);
	echo mysql_num_rows($classresult);



	//get university table
	$sql="SELECT university_name FROM Universities WHERE university_id = '{$classrow['university_id']}'";
	$universityresult=mysql_query($sql);
	$universityrow = mysql_fetch_array($universityresult);	//university row

	$sql = "SELECT updated_recently, url, major_name FROM Majors WHERE major_id = '{$classrow['major']}' AND term_id = '{$classrow['term_id']}'";
	$majorresult = mysql_query($sql);
	$majorrow = mysql_fetch_array($majorresult);

	if($majorrow['updated_recently'] == '0'){
		require_once('scrape_functions.php');

		//echo $majorlisttable . "<br>";
		//echo $majorrow['url'] . "<br>";
		//echo $uni_id . "<br>";
		scrape_the_right_seats($majorrow['url'], $classrow['university_id'], $classrow['term_id']);
		echo "updated";
	}
	$sql = "SELECT seats_avail FROM Classes WHERE class_id = '{$row['class_id']}'";
	$seatsresult = mysql_query($sql);
	$seatsrow = mysql_fetch_array($seatsresult);
	echo $seatsrow['seats_avail'] . "<br>";
	if($seatsrow['seats_avail'] > 0){
		$sql = "SELECT email FROM Users WHERE user_id = {$row['user_id']}";
		$userresult = mysql_query($sql);
		$userrow = mysql_fetch_array($userresult);
		echo $userrow['email'];
		$to = $userrow['email'];
		$subject = "Course " . $classrow['course'] . " has seats available";
		$txt = "Hurray!!! Course " . $classrow['course'] . " has seats available.  Hurry up and sign up for the class before they fill up.  After you do so, go to your classScraper profile to stop watching this class, or else you'll continue to get these notification.";
		$headers = "From: classScraper@foodbuddie.com" . "\r\n";

		mail($to,$subject,$txt,$headers);
		//echo "sent mail ". $userrow['email'] . "</br>";

	}
	
}

?>

