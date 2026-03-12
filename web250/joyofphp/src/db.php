<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

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

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>