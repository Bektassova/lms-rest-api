<?php

/**
 * config.php
 * Database connection file.
 * Creates a PDO connection to the SchoolManagement database.
 */

$db_user = "root";
$db_password = "";
$db_name = "SchoolManagement";

$db = new PDO("mysql:host=127.0.0.1:8888;dbname=" . $db_name . ";charset=utf8",
    $db_user,
    $db_password
);

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>