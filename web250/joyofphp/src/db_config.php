<?php
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "Cars";
} else {
    $host = "sql211.infinityfree.com";
    $username = "if0_41085194";
    $password = "JoKerDoo5PWS";
    $database = "if0_41085194_cars";
}

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
// Automatically selects the correct DB based on environment
$mysqli->select_db($database); 
?>
