<?php
// Enable error reporting to see what's happening
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* Detect environment */
// Check for local IP or the word localhost
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    // LOCAL (MAMP)
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "Cars";
    echo "<!-- Debug: Running on Localhost -->";
} else {
    // HOSTED SERVER (InfinityFree)
    $host = "sql211.infinityfree.com";
    $username = "if0_41085194";
    $password = "JoKerDoo5PWS"; // Make sure this is your Hosting Account Password
    $database = "if0_41085194_cars";
    echo "<!-- Debug: Running on InfinityFree -->";
}

/* Create connection */
$mysqli = new mysqli($host, $username, $password, $database);

/* Check connection */
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

echo "Connected successfully to " . $host;
?>
