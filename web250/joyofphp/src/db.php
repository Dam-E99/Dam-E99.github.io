<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the file path contains "infinityfree"
if (strpos(__FILE__, 'infinityfree.com') !== false) {
    // HOSTED SERVER (InfinityFree)
    $host = "sql211.infinityfree.com";
    $username = "if0_41085194";
    $password = "JoKerDoo5PWS"; 
    $database = "if0_41085194_cars";
    echo "<!-- Debug: Running on InfinityFree Server -->";
} else {
    // LOCAL (MAMP)
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "Cars";
    echo "<!-- Debug: Running on Localhost -->";
}

/* Create connection */
$mysqli = new mysqli($host, $username, $password, $database);

/* Check connection */
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

echo "Connected successfully to " . $host;
?>

