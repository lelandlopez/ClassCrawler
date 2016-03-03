<?php

session_start();
if($_SESSION['logged_in']==false){
    header("Location: http://foodbuddie.com");
}
?>
<?php
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');
$dbname="Groceries";
mysql_select_db("$dbname")or die("cannot select DB");
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
      .col-centered{
          float: none;
          margin: 0 auto;
      }
    </style>
    <title>FoodBuddie</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom SS -->
    <!-- navbar -->
  <link href="css/navbar.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?php
    require_once( ROOT_DIR . '/GUI/navbar.php' );
    ?>
    <?php
    $dbname="Groceries";
    mysql_select_db("$dbname")or die("cannot select DB");
    $query = "SELECT * FROM Groups WHERE group_id='{$_GET['group_id']}'";
    $result=mysql_query($query);
    $row = mysql_fetch_array($result);
    ?>
    <div class ="container">
        <h1><?php echo $row['group_name'];?></h1>


    </div>

</body>

</html>
