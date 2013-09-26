<?php
require_once "config.php";

class Database {
  protected $dbConnection;

  function __construct() {
    $this->dbConnection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
    
    if (!$this->dbConnection) {
      die("Could not connect to MySQL.");
    }

    if (!mysql_select_db(DB_NAME, $this->dbConnection)) {
      die("Could not select database '" . DB_NAME . "'.");
    }
  }

  function selectQuery($query_statement) {
    $mysql_query = mysql_query($query_statement, $this->dbConnection);

    $result = array();

    while ($row = mysql_fetch_assoc($mysql_query)) {
      array_push($result, $row);
    }

    return $result;
  }

  function insertQuery($query_statement) {
    if (mysql_query($query_statement, $this->dbConnection)) {
      return mysql_insert_id($this->dbConnection);
    } else {
      return -1;
    }
  }

  function updateQuery($query_statement) {
    if (mysql_query($query_statement, $this->dbConnection)) {
      return 0;
    } else {
      return -1;
    }
  }
}