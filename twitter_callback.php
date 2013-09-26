<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Load libraries. */
require_once "lib/libraries.php";

session_start();


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

  /* Save the token to the database, if it is not already saved. */
  $database = new Database();
  $users = $database->selectQuery("SELECT * FROM `users` WHERE `screen_name`='" . $access_token["screen_name"] . "'");
  
  if (count($users) == 0) {
    $user_id = TwitterController::createUser($access_token["screen_name"], $access_token["user_id"],
                                             $access_token["oauth_token"], $access_token["oauth_token_secret"]);
    if ($user_id == -1) {
      die("CRITICAL ERROR: Could not create user: " . mysql_error());
    }

    if (TwitterController::setExtractFriendsJob($user_id, $access_token["screen_name"]) == -1) {
      die("CRITICAL ERROR: Could not create 'extract friends' job for user: " . mysql_error());
    }

  }
  
  header("Location: ./index.php");
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header("Location: ./twitter_clearsessions.php");
}