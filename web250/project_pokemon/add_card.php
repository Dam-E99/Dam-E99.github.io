<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $rarity = $_POST['rarity'];
    $set = $_POST['set_name'];

    $stmt = $conn->prepare("INSERT INTO cards (user_id, name, type, rarity, set_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $_SESSION['user_id'], $name, $type, $rarity, $set);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>

<h2>Add Card</h2>
<form method="post">
    <input name="name" placeholder="Card Name"><br><br>
    <input name="type" placeholder="Type"><br><br>
    <input name="rarity" placeholder="Rarity"><br><br>
    <input name="set_name" placeholder="Set"><br><br>
    <button>Add Card</button>
</form>