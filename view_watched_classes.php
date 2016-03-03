<?php
session_start();
require_once('config.php');
require_once( ROOT_DIR . '/Connections/root.php');

if(!isset($_SESSION['logged_in'])){
  header("Location: foodbuddie.com");
}

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
    
    $dbname="ClassScraper";
    mysql_select_db("$dbname")or die("cannot select DB");
    $sql="SELECT * FROM Watches WHERE user_id = '{$_SESSION['user_id']}'";
    $result=mysql_query($sql);

    ?>
    <div class="container">
      <?php
      $num = mysql_num_rows($result);
      ?>
      <h3>You're Watched Classes (<?php echo $num; ?>)</h3>
      <?php
      if($num != 0)
      {
      ?>
      <table class="table">
        <thead>
          <tr>
            <th>University</th>
            <th>Term</th>
            <th>CRN</th>
            <th>Course</th>
            <th>Section</th>
            <th>Title</th>
            <th>Instructor</th>
            <th>Seats Available</th>
          </tr>
        </thead>
        <?php
        while($row = mysql_fetch_array($result)){
        $sql="SELECT * FROM Classes WHERE university_id = '{$row['university_id']}' AND crn = '{$row['crn']}'";
        $tmpresult=mysql_query($sql);
        $classrow = mysql_fetch_array($tmpresult);
        $sql="SELECT university_name FROM Universities WHERE university_id = '{$classrow['university_id']}'";
        $universityresult = mysql_query($sql);
        $universityrow = mysql_fetch_array($universityresult);
        $sql="SELECT term_name FROM Terms WHERE term_id = '{$classrow['term_id']}'";
        $termresult = mysql_query($sql);
        $termrow = mysql_fetch_array($termresult);
          ?>
          <tr>
            <td><?php echo $universityrow['university_name']; ?></td>
            <td><?php echo $termrow['term_name']; ?></td>
            <td><?php echo $classrow['crn']; ?></td>
            <td><?php echo $classrow['course']; ?></td>
            <td><?php echo $classrow['section']; ?></td>
            <td><?php echo $classrow['title']; ?></td>
            <td><?php echo $classrow['instructor']; ?></td>
            <td><?php echo $classrow['seats_avail']; ?></td>
            <td><a href='stop_watching.php?crn=<?php echo $classrow['crn'] . "&university=" . $classrow['university_id'];?>'>Stop Watching</a></td>
          </tr>
          <?php
        }
        ?>
      </table>
      <?php
    } else {
      ?>
      <h4>You are not watching any Classes.  Start watching some through <a href='find_a_class.php'>Find A Class</a></h4>
      <?php
    }
    ?>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="bootstrap/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="jquery-autocomplete/jquery.autocomplete.js"></script>

</body>

</html>
