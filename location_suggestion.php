
<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');
$dbname="Groceries";
mysql_select_db("$dbname")or die("cannot select DB");

require_once( ROOT_DIR . '/prep_Input.php');
$term = $_GET['term'];
$sql = "SELECT business_name FROM Businesses WHERE business_name LIKE '%".$term."%'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$data[] = array(
	'value' => $row['business_name'],
	'label' => $row['business_name']
  	);

}

echo json_encode($data);
?>