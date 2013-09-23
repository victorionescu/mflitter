<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once("config.php");
require_once("twitteroauth/twitteroauth.php");

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST["oauth_token"]) && $_SESSION["oauth_token"] !== $_REQUEST["oauth_token"]) {
  $_SESSION["oauth_status"] = "oldtoken";
  header("Location: ./twitter_clearsessions.php");
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
    $_SESSION["oauth_token"], $_SESSION["oauth_token_secret"]);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST["oauth_verifier"]);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION["access_token"] = $access_token;

/* Remove no longer needed request tokens. */
unset($_SESSION["oauth_token"]);
unset($_SESSION["oauth_token_secret"]);

/* If HTTP response is 200 continue otherwise send to connect page to retry. */
if ($connection->http_code == 200) {
  /* The user has been verified and the access tokens can be saved for future use. */
  $_SESSION["status"] = "verified";

  /* TODO(victorionescu46@gmail.com): Factor this out in an OOP design. */
  /* Save the token to the database, if it is not already saved. */
  $mysql_connection = mysql_connect("127.0.0.1", "root", "my38008s_52");
  if (!$mysql_connection) {
    die("Could not connect: " . mysql_error());
  }
  mysql_select_db("mflitter") or die("Could not select database `mflitter`.");

  $query_statement = "SELECT * FROM `users` WHERE `screen_name`='" . $access_token["screen_name"] . "'";
  $query = mysql_query($query_statement, $mysql_connection);
  if (mysql_num_rows($query) == 0) {
    $insert_query_statement = "INSERT INTO users(screen_name, user_id, access_token, access_token_secret) " .
        "VALUES('" . $access_token["screen_name"] . "', '" . $access_token["user_id"] . "', '" .
        $access_token["oauth_token"] . "', '" . $access_token["oauth_token_secret"] . "')";
    if (!mysql_query($insert_query_statement)) {
      die("Problem while creating the user: " . mysql_error());
    }

    $insert_query_statement = "INSERT INTO friends_jobs(user_id, screen_name, issued_at, next_cursor) VALUES" .
        "(" . mysql_insert_id() . ", '" . $access_token["screen_name"] . "', NOW(), -1)";
    if (!mysql_query($insert_query_statement)) {
      die("Problem while creating the job: " . mysql_error());
    }  
  }
  
  header("Location: ./index.php");
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header("Location: ./twitter_clearsessions.php");
}