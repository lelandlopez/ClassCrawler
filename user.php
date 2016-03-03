<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $dbname="FoodBuddie";
    mysql_select_db("$dbname")or die("cannot select DB");
    $query = "SELECT * FROM Users WHERE user_id='{$_GET['user_id']}'";
    $result=mysql_query($query);
    $row = mysql_fetch_array($result);
    ?>
    <div class ="container">
    	<h3><?php echo $row['username'];?></h3>
    </div>

    <div class="container">
        <h3>Shared Items <small><a href="http://foodbuddie.com/user_shared_items.php?user_id=<?php echo $_GET['user_id'];?>" >See all of the Users Shared Items</a></small></h3>
        <?php
        $dbname="Groceries";
        mysql_select_db("$dbname")or die("cannot select DB");
        $sql="SELECT * FROM Shared_Items WHERE user_id='{$_GET['user_id']}' ORDER BY shared_item_id DESC LIMIT 5";
        $userresult=mysql_query($sql);
        ?>
        <table class="table table-condensed">
            <thead>
              <tr>
                <th>Business Names</th>
                <th>Shared Items</th>
                <th></th>
              </tr>
            </thead>
            <?php
            while($row = mysql_fetch_array($userresult)){
                ?>
                <tr>
                    <?php
                        $dbname="Groceries";
                        mysql_select_db("$dbname")or die("cannot select DB");
                        $sql="SELECT * FROM Items WHERE item_id='{$row['item_id']}'";
                        $result=mysql_query($sql);
                        $item_row = mysql_fetch_array($result);
                       
                        ?>
                    <td>
                        <?php
                        $dbname="Groceries";
                        mysql_select_db("$dbname")or die("cannot select DB");
                        $sql="SELECT * FROM Businesses WHERE business_id='{$item_row['business_id']}'";
                        $result=mysql_query($sql);
                        echo mysql_fetch_array($result)['business_name'];
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $item_row['item_name'];
                        ?>
                    </td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <h3>Groups <small><a href="http://foodbuddie.com/groups.php" >See all of the Users Groups</a></small></h3>
            <?php
            $dbname="Groceries";
            mysql_select_db("$dbname")or die("cannot select DB");
            $sql="SELECT * FROM Group_Members WHERE user_id='{$_SESSION['user_id']}'";
            $result=mysql_query($sql);
            //echo mysql_num_rows($result);
            if(mysql_num_rows($result) != 0){
                $groups='SELECT * FROM Groups WHERE group_id IN (';
                $l = false;
                while($row = mysql_fetch_array($result)){
                    if($l == false){
                        $groups.="'{$row['group_id']}'";
                        $l = true;
                        //echo $friends;
                    } else {
                        $groups.=",'{$row['group_id']}'";
                        //echo $friends;
                    }
                }
                $groups.=") LIMIT 5";
                $groupsresult = mysql_query($groups);
                ?>
                <table class="table table-condensed">
                    <thead>
                      <tr>
                        <th>Group Name</th>
                      </tr>
                    </thead>
                    <?php
                    while($row = mysql_fetch_array($groupsresult)){
                        ?>
                        <tr>
                            <td>
                                <a href="http://foodbuddie.com/group.php?group_id=<?php echo $row['group_id'];?>" ><?php echo $row['group_name']; ?></a>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <?php
            } else {
                echo "The user is not part of any Groups";
            }
            ?>
            </div>
            <div class="col-md-6">
                <h3>Collections <small><a href="http://foodbuddie.com/collections.php" >See All of the Users Collections</a></small></h3>
                <?php
                $dbname="Groceries";
                mysql_select_db("$dbname")or die("cannot select DB");
                $sql="SELECT * FROM Collections WHERE user_id='{$_SESSION['user_id']}'";
                $result=mysql_query($sql);
                ?>
                <?php
                if(mysql_num_rows($result) != 0){
                    ?>
                    <table class="table table-condensed">
                        <thead>
                          <tr>
                            <th>Collection Name</th>
                          </tr>
                        </thead>
                        <?php
                        while($row = mysql_fetch_array($result)){
                            ?>
                            <tr>
                                <td>
                                    <a href="http://foodbuddie.com/collection.php?collection_id=<?php echo $row['collection_id'];?>" ><?php echo $row['collection_name']; ?></a>
                                </td>

                            </tr>
                            <?
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    echo "The user doesn't have any Collections";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>
