<?php
require_once "lib/libraries.php";

session_start();
if (isset($_SESSION["access_token"])) {
  header("Location: unfollow.php");
}

//$database = new Database();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/landing.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active">
            <a href="#">Home</a>
          </li>

          <li>
            <a href="javascript:void(0)">About</a>
          </li>
        </ul>
        <h3 class="text-muted">MFlitter</h3>
      </div>

      <div class="jumbotron">
        <h1>Welcome to MFlitter</h1>
        <p class="lead">
          Using MFlitter is as easy as signing in with your Twitter account. Click on the button below and enjoy!
        </p>
        <p>
          <a class="btn btn-lg btn-info" href="twitter_redirect.php">Sign in with Twitter</a>
        </p>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>