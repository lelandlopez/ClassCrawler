<?php

$hostname_root = "localhost";
$database_root = "FoodBuddie";
$username_root = "lelandp";
$password_root = "Waiakea2009";
$asdf = mysql_pconnect($hostname_root, $username_root, $password_root) or trigger_error(mysql_error(),E_USER_ERROR);

$dbname="ClassScraper";
mysql_select_db("$dbname")or die("cannot select DB");

class scrapedClass { 
    public $crn; 
    public $course;
    public $title;
    public $section;
    public $instructor;
    public $seats_avail;
    public $curr_wait;
    public $wait_avail;
} 

require_once('scrape_functions.php');

scrape_seats('https://www.sis.hawaii.edu/uhdad/avail.classes?i=MAN&t=201540', '//ul[@class="subjects"]/li/a/@href', "https://www.sis.hawaii.edu/uhdad/", '//table[@class="listOfClasses"]/tr', 'UniversityOfHawaiiAtManoa');





?>
