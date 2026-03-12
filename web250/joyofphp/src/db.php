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
    $host = "sql211.infinityfree.com";
    $username = "if0_41085194";
    $password = "JoKerDoo5PWS";
    $database = "if0_41085194_cars";

}

/* Create connection */
$mysqli = new mysqli($host, $username, $password, $database);

/* Check connection */
if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

?>