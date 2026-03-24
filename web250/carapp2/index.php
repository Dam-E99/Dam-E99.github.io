<?php
require_once 'config_db.php';
$message = "";
$edit_car = null;

// 1. DELETE LOGIC
if (isset($_GET['delete'])) {
    $vin = $mysqli->real_escape_string($_GET['delete']);
    $mysqli->query("DELETE FROM inventory WHERE VIN = '$vin'");
    header("Location: index.php?msg=Vehicle+successfully+removed");
    exit();
}

// 2. EDIT MODE (Fetch data for pre-population)
if (isset($_GET['edit'])) {
    $vin = $mysqli->real_escape_string($_GET['edit']);
    $res = $mysqli->query("SELECT * FROM inventory WHERE VIN = '$vin'");
    $edit_car = $res->fetch_assoc();
}

// 3. INSERT OR UPDATE LOGIC
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_car'])) {
    $vin = trim($mysqli->real_escape_string($_POST['VIN']));
    $make = trim($mysqli->real_escape_string($_POST['Make']));
    $model = trim($mysqli->real_escape_string($_POST['Model']));
    $price = (float)$_POST['Asking_Price'];
    $is_update = $_POST['is_update'];

    if ($is_update == "1") {
        $query = "UPDATE inventory SET Make='$make', Model='$model', ASKING_PRICE=$price WHERE VIN='$vin'";
        $message = "Updated $make $model in inventory!";
    } else {
        $query = "INSERT INTO inventory (VIN, Make, Model, ASKING_PRICE) VALUES ('$vin', '$make', '$model', $price)";
        $message = "Added new $make $model to the lot!";
    }
    
    $mysqli->query($query);
    header("Location: index.php?msg=" . urlencode($message));
    exit();
}

if (isset($_GET['msg'])) $message = $_GET['msg'];
$inventory = $mysqli->query("SELECT * FROM inventory ORDER BY Make ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dazzling Dodo's Used Cars</title>
    <link rel="stylesheet" href="styles/default.css">
    <script src="https://lint.page/kit/880bd5.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>🦤 Dazzling Dodo's Used Cars</h1>
        </header>

        <main>
            <?php if ($message): ?>
                <div class="msg-success"><h3><?php echo htmlspecialchars($message); ?></h3></div>
            <?php endif; ?>

            <!-- COMBINED FORM: INSERT & UPDATE -->
            <section class="form-section">
                <h2><?php echo $edit_car ? "Edit Car Details" : "Add a New Car"; ?></h2>
                <form action="index.php" method="post" class="car-form">
                    <input type="hidden" name="is_update" value="<?php echo $edit_car ? '1' : '0'; ?>">
                    
                    <input type="text" name="VIN" placeholder="VIN Number" value="<?php echo $edit_car['VIN'] ?? ''; ?>" <?php echo $edit_car ? 'readonly' : 'required'; ?>>
                    <input type="text" name="Make" placeholder="Make (e.g., Ford)" value="<?php echo $edit_car['Make'] ?? ''; ?>" required>
                    <input type="text" name="Model" placeholder="Model (e.g., Mustang)" value="<?php echo $edit_car['Model'] ?? ''; ?>" required>
                    <input type="number" name="Asking_Price" placeholder="Asking Price" value="<?php echo $edit_car['ASKING_PRICE'] ?? ''; ?>" required class="full-width">
                <!-- New From Info -->
                    <input type="number" name="Year" placeholder="Year" value="<?php echo $edit_car['YEAR'] ?? ''; ?>" required>
                    <input type="text" name="Trim" placeholder="Trim" value="<?php echo $edit_car['TRIM'] ?? ''; ?>">
                    <input type="text" name="Color" placeholder="Exterior Color" value="<?php echo $edit_car['EXT_COLOR'] ?? ''; ?>">
                    <input type="text" name="Interior" placeholder="Interior Color" value="<?php echo $edit_car['INT_COLOR'] ?? ''; ?>">
                    <input type="number" name="Mileage" placeholder="Mileage" value="<?php echo $edit_car['MILEAGE'] ?? ''; ?>">
                    <input type="text" name="Transmission" placeholder="Transmission" value="<?php echo $edit_car['TRANSMISSION'] ?? ''; ?>">

                    
                    <button type="submit" name="save_car" class="btn-submit <?php echo $edit_car ? 'btn-update' : ''; ?>">
                        <?php echo $edit_car ? "Update Inventory" : "Add to Inventory"; ?>
                    </button>
                    <?php if ($edit_car): ?>
                        <a href="index.php" style="text-align: center; grid-column: span 3;">Cancel Edit</a>
                    <?php endif; ?>
                </form>
            </section>

            <!-- VIEW SECTION -->
            <table>
                <thead>
                    <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Asking Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $inventory->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['Make']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['Model']); ?></td>
                        <td>$<?php echo number_format($row['ASKING_PRICE'], 0); ?></td>
                        <td>
                            <a href="?edit=<?php echo $row['VIN']; ?>" class="btn-edit">Edit</a>
                            <a href="?delete=<?php echo $row['VIN']; ?>" class="btn-del" onclick="return confirm('Delete this vehicle?')">Delete ❌</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>

        <footer>
            <p>Designed by Soto Air Design Co. | Don't sue us just because we use gum to hold our cars together.</p>
        </footer>
    </div>
</body>
</html>
