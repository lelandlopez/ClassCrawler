<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "blah";
$hostname_root = "localhost";
$database_root = "FoodBuddie";
$username_root = "lelandp";
$password_root = "Waiakea2009";
$asdf = mysql_pconnect($hostname_root, $username_root, $password_root) or trigger_error(mysql_error(),E_USER_ERROR);

$dbname="ClassScraper";
mysql_select_db("$dbname")or die("cannot select DB");

require_once('scrape_functions.php');

$sql = "SELECT * FROM Terms";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	
	if($row['scrape_type'] == '0'){
		//if($row['term_id'] == '3'){
		ss($row['base_url'], $row['xpath_subject_row'], $row['xpath_major_url'], $row['base_url_base'], $row['xpath_class_row'], $row['university_id'], $row['term_id']);
		//}
	}
	if($row['scrape_type'] == '1'){
		ss1($row['base_url'], $row['xpath_subject_row'], $row['xpath_major_url'], $row['base_url_base'], $row['xpath_class_row'], $row['university_id'], $row['term_id']);
	}

	if($row['scrape_type'] == '2'){
	//	ss3('http://schedule.berkeley.edu/srchsmr.html', '//select[@name="p_deptname"]/option', NULL, '//table', NULL, '12', '6');
		ss2($row['base_url'], $row['xpath_subject_row'], $row['xpath_major_url'], $row['base_url_base'], $row['xpath_class_row'], $row['university_id'], $row['term_id']);
	}
	
	if($row['scrape_type'] == '3'){
	//	ss3('http://schedule.berkeley.edu/srchsmr.html', '//select[@name="p_deptname"]/option', NULL, '//table', NULL, '12', '6');
		ss3($row['base_url'], $row['xpath_subject_row'], $row['xpath_major_url'], $row['base_url_base'], $row['xpath_class_row'], $row['university_id'], $row['term_id']);
	}

	if($row['scrape_type'] == '4'){
	//	ss3('http://schedule.berkeley.edu/srchsmr.html', '//select[@name="p_deptname"]/option', NULL, '//table', NULL, '12', '6');
		ss4($row['base_url'], $row['xpath_subject_row'], $row['xpath_major_url'], $row['base_url_base'], $row['xpath_class_row'], $row['university_id'], $row['term_id']);
	}
	
}








?>
