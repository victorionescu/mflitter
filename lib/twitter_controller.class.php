<?php
require_once "config.php";

class TwitterController {
  public static $database;

  public static function init() {
    self::$database = new Database();
  }

  public static function createUser($screen_name, $user_id, $access_token, $access_token_secret) {
    return self::$database->insertQuery("INSERT INTO users(screen_name, user_id, access_token, access_token_secret) " .
                                        "VALUES('" . $screen_name . "', " .
                                               "'" . $user_id . "', " .
                                               "'" . $access_token . "', " .
                                               "'" . $access_token_secret . "')");
  }

  public static function setExtractFriendsJob($user_id, $screen_name) {
    if (count(self::$database->selectQuery("SELECT * FROM `friends_jobs` WHERE `user_id`='" . $user_id . "'")) > 0) {
      return self::$database->updateQuery("UPDATE `friends_jobs` SET `cursor`='-1' WHERE `user_id`='" . $user_id . "'");
    } else {
      return self::$database->insertQuery("INSERT INTO friends_jobs(user_id, screen_name, issued_at, next_cursor) " .
                                          "VALUES('" . $user_id . "', " .
                                                 "'" . $screen_name . "', NOW(), -1)");
    }
  }
}

TwitterController::init();