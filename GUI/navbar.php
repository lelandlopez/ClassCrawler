<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../">ClassCrawler</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="../">Home</a></li>
        <li><a href="find_a_class.php">Find A Class</a></li>
      </ul>
      <?php
        if(!isset($_SESSION['logged_in'])){
          ?>
          <ul class="nav navbar-nav pull-right">
            <li><a href="login.php">Sign In</a></li>
            <li><a href="signup.php">Sign Up</a></li>

          </ul>
          <?php
        }
        else{
          ?>
          <ul class="nav navbar-nav pull-right">
            <li><a href="view_watched_classes.php">View Your Watched Classes</a></li>
            <li><a href="logout.php">Sign Out</a></li>
          </ul>
          <?php
        }
      ?>
    </div><!--/.nav-collapse -->
  </div>
</nav>