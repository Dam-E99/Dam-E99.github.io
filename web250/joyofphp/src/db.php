<?php

$mysqli = new mysqli("localhost", "root", "root", "Cars");

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>