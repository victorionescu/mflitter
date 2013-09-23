<?php

session_start();
if (!isset($_SESSION["access_token"])) {
  header("Location: index.php");
}

$mysql_connection = mysql_connect("127.0.0.1", "root", "my38008s_52");
if (!$mysql_connection) {
  header("Location: twitter_clearsessions.php");
}
mysql_select_db("mflitter") or die("Could not select database 'mflitter'.");

$query_statement = "SELECT * FROM `users` WHERE `screen_name`='" . $_SESSION["access_token"]["screen_name"] . "'";
$mysql_query = mysql_query($query_statement, $mysql_connection);

if (mysql_num_rows($mysql_query) != 1) {
  header("Location: twitter_clearsessions.php");
}

$row = mysql_fetch_assoc($mysql_query);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/application.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body rel="<?php echo $row["id"]; ?>">
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">MFlitter</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <!--<li class="active"><a href="#">Not following back</a></li>
            <li><a href="#about">No Profile Image</a></li>
            <li><a href="#contact">Fake Following</a></li>-->
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Unfollow <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Not following back</a></li>
                <li><a href="no_profile_image.php">No profile image</a></li>
                <li><a href="#">Fake Following</a></li>
                <li><a href="#">Non-English</a></li>
                <li><a href="#">High Ratio</a></li>
                <li><a href="#">Inactive</a></li>
                <li><a href="#">Talkative</a></li>
                <li><a href="#">Quiet</a></li>
                <!--<li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>-->
              </ul>
            </li>
            <li><a href="track_unfollows.php">Track Unfollows</a><li>
            <li><a href="#">Search</a></li>
            <li><a href="#">PowerPost</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <!--<li class="active"><a href="javascript:void(0)">Unfollow</a></li>
            <li><a href="javascript:void(0)">Search</a></li>-->
            <li><a href="twitter_clearsessions.php">Sign Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>