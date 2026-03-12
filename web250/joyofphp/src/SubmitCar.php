
<html>
<head>
    <title>Car Saved</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" >

<?php 
// Capture the values posted to this php program from the text fields

$VIN =  trim( $_REQUEST['VIN']) ;
$Make = trim( $_REQUEST['Make']) ;
$Model = trim( $_REQUEST['Model']) ;
$Price =  $_REQUEST['Asking_Price'] ;


//Build a SQL Query using the values from above

$query = "INSERT INTO inventory
  (VIN, Make, Model, ASKING_PRICE)
   VALUES (
   '$VIN', 
   '$Make', 
   '$Model',
    $Price
    )";

// Print the query to the browser so you can see it
echo ($query. "<br>");

include 'db.php';

  echo 'Connected successfully to mySQL. <BR>'; 
  
//select a database to work with
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $mysqli->select_db("Cars");
    echo "Selected the Cars database (local)<br>";
} else {
    $mysqli->select_db("if0_41085194_cars");
    echo "Selected the hosted database<br>";
}

/* Try to insert the new car into the database */
if ($result = $mysqli->query($query)) {
    echo "<p>You have successfully entered $Make $Model into the database.</P>";
}
else
{
    echo "Error entering $VIN into database: " . $mysqli->error."<br>";
}
$mysqli->close();
include 'menu.php';
?>
</body>
</html>