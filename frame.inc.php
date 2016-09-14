<?php
  ob_start();
  require_once "config.inc.php";
  function assert_database() {
    global $db;
    if (!defined("SQL_UP")) $db = new PDO(SQL_URI, SQL_USER, SQL_PASSWORD);
  }
?>
