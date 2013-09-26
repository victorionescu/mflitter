<?php

require_once "lib/libraries.php";

session_start();

/* Build TwitterOAuth object with client credentials. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

/* Get temporary credentials. */
$request_token = $connection->getRequestToken(OAUTH_CALLBACK);

/* Save temporary credentials to session. */
$_SESSION["oauth_token"] = $request_token["oauth_token"];
$_SESSION["oauth_token_secret"] = $request_token["oauth_token_secret"];

switch ($connection->http_code) {
  case 200:
    /* Build an authorize URL and redirect user to Twitter. */
    $url = $connection->getAuthorizeURL($request_token);
    header("Location: " . $url);
    break;
  default:
    /* Notify that something went wrong. */
    echo "Could not connect to Twitter. Please try again later.";
}