<?php
require_once "../lib/libraries.php";

if (!isset($_POST["user_id"]) || !isset($_POST["friends_ids"])) {
  die("Both User ID and Friends IDs have to be set.");
}
  
$screen_names = preg_split("/\|/", $_POST["friends_ids"]);

$database = new Database();

$unfollows = $database->selectQuery("SELECT * FROM `unfollows` WHERE `user_id`=" . $_POST["user_id"]);

if (count($unfollows) == 0) {
  $database->insertQuery("INSERT INTO unfollows(user_id) VALUES(" . $_POST["user_id"] . ")");
}

for ($i = 0; $i < count($screen_names); $i++) {
  $screen_name = $screen_names[$i];

  $friend_unfollows = $database->selectQuery("SELECT * FROM `unfollows_friends` WHERE `user_id`=" . $_POST["user_id"] . " AND " .
                                                                                     "`screen_name`='" . $screen_name . "'");

  if (count($friend_unfollows) == 0) {
    $database->insertQuery("INSERT INTO unfollows_friends(user_id, screen_name, status) " .
                           "VALUES(" . $_POST["user_id"] . ", '" . $screen_name . "', false)");
  }
}

header("Location: ../track_unfollows.php");