<?php
/**
 * Joy of PHP sample code
 * Demonstrates how to modify an existing database table.
 */

include 'db.php';

echo 'Connected successfully to MySQL.<br>';

$query = "ALTER TABLE inventory ADD Primary_Image VARCHAR(250) NULL AFTER SALE_DATE";

echo "<p>***********</p>";
echo $query;
echo "<p>***********</p>";

if ($mysqli->query($query) === TRUE) {
    echo "Database table 'INVENTORY' modified";
} else {
    echo "Error: " . $mysqli->error . "<br>";
}

$mysqli->close();

echo "<br><br><a href='index.html'>Home</a>";
?>