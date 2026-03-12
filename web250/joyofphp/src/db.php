<?php

/* Detect environment */
if ($_SERVER['SERVER_NAME'] == 'localhost') {

    // LOCAL (MAMP)
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "Cars";

} else {

    // HOSTED SERVER
    $host = "your_host";
    $username = "your_db_username";
    $password = "your_db_password";
    $database = "your_db_name";

}

/* Create connection */
$mysqli = new mysqli($host, $username, $password, $database);

/* Check connection */
if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

?>