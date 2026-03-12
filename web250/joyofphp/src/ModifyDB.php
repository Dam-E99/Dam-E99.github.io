<?php
/**
 * Joy of PHP sample code
 * Demonstrates how to modify an existing database table.
 */
include 'db.php';

   if (!$mysqli) { 
      die("Could not connect: ".$mysqli->error."<br>"); 
  } 
  echo 'Connected successfully to mySQL. <BR>'; 
  
//select a database to work with

// Check if the column exists first
$result = $mysqli->query("SHOW COLUMNS FROM `inventory` LIKE 'Primary_Image'");

if ($result->num_rows == 0) {
    // Column doesn't exist, so add it
    $query = "ALTER TABLE `inventory` ADD `Primary_Image` VARCHAR(250) NULL AFTER `SALE_DATE`";
    $mysqli->query($query);
    echo "Column added.";
} else {
    echo "Column already exists";
}

?>