<?php
 $q=$_GET['q'];
 $my_data=mysql_real_escape_string($q);
 $mysqli=mysqli_connect('localhost','lelandp','Waiakea2009','FoodBuddie') or die("Database Error");
 $sql="SELECT item_name FROM Item_Names WHERE item_name LIKE '%$my_data%' ORDER BY item_name";
 $result = mysqli_query($mysqli,$sql) or die(mysqli_error());
echo "blah";
 if($result)
 {
  while($row=mysqli_fetch_array($result))
  {
   echo $row['item_name']."\n";
  }
 }
?>