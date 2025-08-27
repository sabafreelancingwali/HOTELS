<?php
// config.php - DB connection used by other PHP files
$DB_HOST = 'localhost';
$DB_NAME = 'dbvnr5pqpglhqu';
$DB_USER = 'upknjbhg8vsv8';
$DB_PASS = 'yz88ljtio3sf';
 
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("DB Connection failed: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
?>
 
