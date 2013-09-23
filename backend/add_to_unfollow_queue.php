<?php
  if (!isset($_POST["user_id"])) {
    die("User ID is not set.");
  }

  if (!isset($_POST["friends_ids"])) {
    die("Friends IDs are not set.");
  }

  $screen_names = preg_split("/\|/", $_POST["friends_ids"]);

  $mysql_connection = mysql_connect("127.0.0.1", "root", "my38008s_52");

  if (!$mysql_connection) {
    die("ERROR: Could not connect to MySQL.");
  }

  mysql_select_db("mflitter") or die("ERROR: Could not select database 'mflitter'.");

  $query_statement = "SELECT * FROM `unfollows` WHERE `user_id`=" . $_POST["user_id"];
  $mysql_query = mysql_query($query_statement);

  if (mysql_num_rows($mysql_query) == 0) {
    $insert_query_statement = "INSERT INTO unfollows(user_id) VALUES(" . $_POST["user_id"] . ")";
    mysql_query($insert_query_statement);
  }

  for ($i = 0; $i < count($screen_names); $i++) {
    $screen_name = $screen_names[$i];

    $query_statement = "SELECT * FROM `unfollows_friends` WHERE `user_id`=" . $_POST["user_id"] .
        " AND `screen_name`='" . $screen_name . "'";

    $mysql_query = mysql_query($query_statement);

    if (mysql_num_rows($mysql_query) == 0) {
      $insert_query_statement = "INSERT INTO unfollows_friends(user_id, screen_name, status) " .
          "VALUES(" . $_POST["user_id"] . ", '" . $screen_name . "', false)";
      mysql_query($insert_query_statement);
    }
  }

  header("Location: ../track_unfollows.php");
?>