<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome to PokeLot</h2>

<a href="add_card.php">Add Card</a> |
<a href="logout.php">Logout</a>