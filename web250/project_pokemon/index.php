<?php
session_start();
require_once 'config_db.php';

// ============================
// CREATE TABLES (AUTO SETUP)
// ============================

// USERS TABLE
$mysqli->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)");

// DEFAULT USER
$checkUser = $mysqli->query("SELECT id FROM users WHERE username = 'testuser'");
if ($checkUser->num_rows == 0) {
    $pass = password_hash("LetMeIn!", PASSWORD_DEFAULT);
    $mysqli->query("INSERT INTO users (username, password)
                    VALUES ('testuser', '$pass')");
}

// DEFAULT ADMIN (Add this below your default user check)
$checkAdmin = $mysqli->query("SELECT id FROM users WHERE username = 'admin'");
if ($checkAdmin->num_rows == 0) {
    $adminPass = password_hash("AdminPass123", PASSWORD_DEFAULT);
    $mysqli->query("INSERT INTO users (username, password)
                    VALUES ('admin', '$adminPass')");
}

// POKEMON TABLE
$mysqli->query("CREATE TABLE IF NOT EXISTS pokemon_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    card_name VARCHAR(100),
    type VARCHAR(50),
    rarity VARCHAR(50),
    set_name VARCHAR(100),
    card_number VARCHAR(20),
    card_condition VARCHAR(50)
)");

 // SEARCH 
$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';

$where = "";
if ($search !== '') {
    $where = "WHERE card_name LIKE '%$search%' OR type LIKE '%$search%'";
}



// ============================
// LOGIN SYSTEM
// ============================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $user = $mysqli->real_escape_string($_POST['username']);
    $pass = $_POST['password'];

    $res = $mysqli->query("SELECT * FROM users WHERE username='$user'");
    $row = $res->fetch_assoc();

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['username'] = $user;
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php?msg=Logged+in");
        exit();
    } else {
        header("Location: index.php?msg=Invalid+login");
        exit();
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php?msg=Logged+out");
    exit();
}

// REGISTER (Create Account)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $user = $mysqli->real_escape_string($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $mysqli->query("SELECT id FROM users WHERE username='$user'");
    
    if ($check->num_rows > 0) {
        header("Location: index.php?msg=Username+already+exists");
    } else {
        $mysqli->query("INSERT INTO users (username, password) VALUES ('$user', '$pass')");
        header("Location: index.php?msg=Account+created!+Please+login");
    }
    exit();
}

$message = $_GET['msg'] ?? "";
$edit_card = null;


// ============================
// CREATE / UPDATE CARD
// ============================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_card']) && isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];
    $is_admin = ($_SESSION['username'] === 'admin'); // Check if admin

    $card_name = $mysqli->real_escape_string($_POST['card_name']);
    $type = $mysqli->real_escape_string($_POST['type']);
    $rarity = $mysqli->real_escape_string($_POST['rarity']);
    $set_name = $mysqli->real_escape_string($_POST['set_name']);
    $card_number = $mysqli->real_escape_string($_POST['card_number']);
    $condition = $mysqli->real_escape_string($_POST['card_condition']);

    if ($_POST['is_update'] == "1") {
        $id = (int)$_POST['id'];

        // ADMIN BONUS: If admin, ignore the user_id check
        $admin_check = $is_admin ? "" : " AND user_id=$user_id";

        $query = "UPDATE pokemon_cards SET 
            card_name='$card_name',
            type='$type',
            rarity='$rarity',
            set_name='$set_name',
            card_number='$card_number',
            card_condition='$condition'
            WHERE id=$id $admin_check";
    } else {
        // Create always uses the logged-in user's ID
        $query = "INSERT INTO pokemon_cards 
        (user_id, card_name, type, rarity, set_name, card_number, card_condition)
        VALUES 
        ($user_id, '$card_name', '$type', '$rarity', '$set_name', '$card_number', '$condition')";
    }

    $mysqli->query($query);
    header("Location: index.php?msg=Saved");
    exit();
}



// ============================
// DELETE
// ============================
if (isset($_GET['delete']) && isset($_SESSION['user_id'])) {
    $id = (int)$_GET['delete'];
    $user_id = $_SESSION['user_id'];

    // Admin can delete anything, others only their own
    $admin_check = ($_SESSION['username'] === 'admin') ? "" : " AND user_id=$user_id";
    
    $mysqli->query("DELETE FROM pokemon_cards WHERE id=$id $admin_check");
    header("Location: index.php?msg=Deleted");
    exit();
}


// ============================
// EDIT MODE
// ============================
if (isset($_GET['edit']) && isset($_SESSION['user_id'])) {
    $id = (int)$_GET['edit'];
    $user_id = $_SESSION['user_id'];

    // Admin can edit anything, others only their own
    $admin_check = ($_SESSION['username'] === 'admin') ? "" : " AND user_id=$user_id";

    $res = $mysqli->query("SELECT * FROM pokemon_cards WHERE id=$id $admin_check");
    $edit_card = $res->fetch_assoc();
}


// ============================
// FETCH USER DATA
// ============================
$cards = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ADMIN BONUS LOGIC: If username is admin, see everything
    if ($_SESSION['username'] === 'admin') {
        $where = "WHERE 1=1"; 
    } else {
        $where = "WHERE user_id=$user_id";
    }

    if ($search !== '') {
        $where .= " AND (card_name LIKE '%$search%' OR type LIKE '%$search%')";
    }

    $cards = $mysqli->query("SELECT * FROM pokemon_cards $where");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<link rel="stylesheet" href="styles/styles.css">
<title>PokeLot</title>

</head>

<body>

<h1>🎴 PokeLot - Pokémon Collection Tracker</h1>

<?php if ($message): ?>
<p class="msg"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>


<!-- LOGIN -->
<?php if (!isset($_SESSION['username'])): ?>

<section class="form-section">
    <h2>Create Account</h2>
    <form method="post">
        <input type="text" name="username" placeholder="New Username" required>
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit" name="register" class="btn-submit">Register</button>
    </form>
</section>

<form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>
<?php endif; ?>


<!-- LOGGED IN -->
<?php if (isset($_SESSION['username'])): ?>

<p>
Welcome, <?php echo $_SESSION['username']; ?> |
<a href="?logout=true">Logout</a>
</p>

<!-- FORM -->
<form method="post">
    <input type="hidden" name="is_update" value="<?php echo $edit_card ? 1 : 0; ?>">
    <input type="hidden" name="id" value="<?php echo $edit_card['id'] ?? ''; ?>">

    <input type="text" name="card_name" placeholder="Card Name" value="<?php echo $edit_card['card_name'] ?? ''; ?>" required>
    <input type="text" name="type" placeholder="Type" value="<?php echo $edit_card['type'] ?? ''; ?>">
    <input type="text" name="rarity" placeholder="Rarity" value="<?php echo $edit_card['rarity'] ?? ''; ?>">
    <input type="text" name="set_name" placeholder="Set Name" value="<?php echo $edit_card['set_name'] ?? ''; ?>">
    <input type="text" name="card_number" placeholder="Card Number" value="<?php echo $edit_card['card_number'] ?? ''; ?>">
    <input type="text" name="card_condition" placeholder="Condition" value="<?php echo $edit_card['card_condition'] ?? ''; ?>">

    <button type="submit" name="save_card">
        <?php echo $edit_card ? "Update Card" : "Add Card"; ?>
    </button>
</form>

<div class="search-section">
    <form method="get">
        <input type="text" name="search" placeholder="Search cards..." 
               value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn-submit">Search</button>

        <?php if ($search !== ''): ?>
            <a href="index.php">Clear</a>
        <?php endif; ?>
    </form>
</div>


<!-- TABLE -->
<table>
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Rarity</th>
    <th>Set</th>
    <th>Number</th>
    <th>Condition</th>
    <th>Actions</th>
</tr>

<?php if ($cards->num_rows > 0): ?>
    <?php while ($row = $cards->fetch_assoc()): ?>

        <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']): ?>
            <tr>
                <form method="post">
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="is_update" value="1">
                        <input type="text" name="card_name" value="<?php echo $row['card_name']; ?>">
                    </td>

                    <td><input type="text" name="type" value="<?php echo $row['type']; ?>"></td>
                    <td><input type="text" name="rarity" value="<?php echo $row['rarity']; ?>"></td>
                    <td><input type="text" name="set_name" value="<?php echo $row['set_name']; ?>"></td>
                    <td><input type="text" name="card_number" value="<?php echo $row['card_number']; ?>"></td>
                    <td><input type="text" name="card_condition" value="<?php echo $row['card_condition']; ?>"></td>

                    <td>
                        <button type="submit" name="save_card">Save</button>
                        <a href="index.php">Cancel</a>
                    </td>
                </form>
            </tr>

        <?php else: ?>
            <tr>
                <td><?php echo $row['card_name']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['rarity']; ?></td>
                <td><?php echo $row['set_name']; ?></td>
                <td><?php echo $row['card_number']; ?></td>
                <td><?php echo $row['card_condition']; ?></td>

                <td>
                    <a class="btn edit" href="?edit=<?php echo $row['id']; ?>">Edit</a>
                    <a class="btn delete"
                       href="?delete=<?php echo $row['id']; ?>"
                       onclick="return confirm('Delete this card?')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endif; ?>

    <?php endwhile; ?>

<?php else: ?>
    <tr>
        <td colspan="7">No cards found. Add your first Pokémon card!</td>
    </tr>
<?php endif; ?>
</table>

<?php endif; ?>

</body>
</html>