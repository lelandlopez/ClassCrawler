<!--
index for foodbuddie.com

-->

<!--
<?php
session_start();
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');
$dbname="FoodBuddie";
mysql_select_db("$dbname")or die("cannot select DB");
?>
<?php
require_once( ROOT_DIR . '/prep_Input.php');
$_GET['recipe_id'] = prep_Input($_GET['recipe_id']);
?>

<?php
require_once( ROOT_DIR . '/logscripts/login_form.php' );
?>

<?php
require_once( ROOT_DIR . '/GUI/menu.php' );
?>

-->


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
    <title>ClassScraper</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom SS -->
    <!-- navbar -->
  <link href="css/navbar.css" rel="stylesheet">

  <link href="css/onoffswitch.css" rel="stylesheet">

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
    if($_SESSION['logged_in'] == false){
    ?>
    <div class="container">
      <div class="center-block">
      <form class="form-horizontal" role="form" action="check_login.php" method="post">
        <div class="form-group">
          <label for="inputEmail" class="col-sm-4 control-label">Email</label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-4 control-label">Password</label>
          <div class="col-sm-4">
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-4 col-sm-4">
            <button type="submit" class="btn btn-default">Sign in</button>
          </div>
        </div>
      </form>
      </div>
    </div>
    <?php
    } else {
      echo "You are Logged In";
    }
    ?>

    <!-- jQuery Version 1.11.0 -->
    <script src="bootstrap/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="jquery-autocomplete/jquery.autocomplete.js"></script>

</body>

</html>
