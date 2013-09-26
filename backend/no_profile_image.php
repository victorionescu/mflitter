<?php
require_once "../lib/libraries.php";

if (!isset($_POST["user_id"]) || !isset($_POST["lower_bound"])) {
  die("Both User ID and Lower Bound have to be set.");
}

$database = new Database();

$friends = $database->selectQuery("SELECT * FROM `friends` WHERE `default_profile_image` IS TRUE AND " .
                                                                "`user_id`='" . $_POST["user_id"] . "' AND " .
                                                                "`id`>" . $_POST["lower_bound"] . " " .
                                                                "ORDER BY `id` ASC");

$job = $database->selectQuery("SELECT * FROM `friends_jobs` WHERE `user_id`='" . $_POST["user_id"] . "'");

if (count($job) != 1) {
  die("CRITICAL ERROR: " . count($job) . " jobs for user " . $_POST["user_id"] . ".");
}

$job = $job[0];

$job_done = ($job["next_cursor"] == 0);

$response = array();
$response["job_done"] = $job_done;
$response["friends"] = $friends;

echo json_encode($response);