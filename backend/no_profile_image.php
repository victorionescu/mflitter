<?php
  if (!isset($_GET["user_id"])) {
    die("User ID is not set");
  }

  if (!isset($_GET["lower_bound"])) {
    die("Lower bound is not set.");
  }  

  $mysql_connection = mysql_connect("127.0.0.1", "root", "my38008s_52");

  if (!$mysql_connection) {
    die("Could not connect to MySQL: " . mysql_error());
  }
  mysql_select_db("mflitter") or die("Could not select database 'mflitter'.");

  $query_statement = "SELECT * FROM `friends` WHERE  `default_profile_image` IS TRUE AND `user_id`=" . $_GET["user_id"] . 
      " AND `id`>" . $_GET["lower_bound"] . " ORDER BY `id` ASC";

  $mysql_query = mysql_query($query_statement, $mysql_connection);

  $results = array();

  while ($row = mysql_fetch_assoc($mysql_query)) {
    array_push($results, $row);
  }

  echo json_encode($results);
?>