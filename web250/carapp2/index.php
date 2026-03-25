<?php
session_start();
require_once 'config_db.php';

$limit = 20;

$page = isset($_GET['p']) && $_GET['p'] > 0 ? (int)$_GET['p'] : 1;

$offset = max(0, ($page - 1) * $limit);

// Fetch inventory
$inventory = $mysqli->query("
    SELECT * FROM inventory 
    ORDER BY Make ASC 
    LIMIT $limit OFFSET $offset
");

// Count total
$total_res = $mysqli->query("SELECT COUNT(*) as total FROM inventory");
$total_cars = $total_res->fetch_assoc()['total'];

$total_pages = ceil($total_cars / $limit);


// LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $user = $mysqli->real_escape_string($_POST['username']);
    $pass = $_POST['password'];

    $res = $mysqli->query("SELECT * FROM users WHERE username='$user'");
    $row = $res->fetch_assoc();

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['username'] = $user;
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

// --- Scary Reset Logic ---
if (isset($_GET['run_setup']) && isset($_SESSION['username'])) {

    echo "<p>- Creating users table (if not exists)...</p>";

        $mysqli->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        password VARCHAR(255),
        first_name VARCHAR(50),
        last_name VARCHAR(50)
    )");

    echo "<p>- Inserting test user...</p>";

    $pass = password_hash("LetMeIn!", PASSWORD_DEFAULT);

   $mysqli->query("INSERT IGNORE INTO users (username, password, first_name, last_name)
                   VALUES ('web250user', '$pass', 'Web', 'User')");

    // Drop logic
    echo "<h2>Well, you asked for it...</h2>";
    echo "<p>- Dropping all fields in inventory...</p>";
    $mysqli->query("DROP TABLE IF EXISTS inventory");
    echo "<p>- Dropping inventory table...</p>";

    // Recreate logic
    echo "<p>- Recreating inventory table...</p>";
    $create = "CREATE TABLE inventory (
        VIN varchar(17) PRIMARY KEY, YEAR INT, Make varchar(50), Model varchar(100), 
        TRIM varchar(50), EXT_COLOR varchar(50), INT_COLOR varchar(50), 
        ASKING_PRICE DECIMAL(10,2), MILEAGE INT, TRANSMISSION varchar(50)
    )";
    $mysqli->query($create);

    // Repopulate logic
    echo "<p>- Repopulating inventory with 100 cars...</p>";
    // PASTE YOUR 100 MOCKAROO INSERTS HERE
    $sql = "INSERT INTO inventory (VIN, Make, Model, ASKING_PRICE) VALUES ('TEST1', 'Toyota', 'Camry', 20000);
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WA1LFBFP3DA287453', 1997, 'Cadillac', 'Catera', 'ac', 'Teal', 'Teal', 495702.44, 62607, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JTDJTUD34ED823909', 1997, 'Land Rover', 'Defender', 'sed magna', 'Violet', 'Mauv', 926946.71, 122720, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WP0AB2A89CS463066', 2003, 'BMW', '3 Series', 'imperdiet sapien', 'Blue', 'Puce', 837836.65, 127974, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBA3B3C58FF596705', 2007, 'Panoz', 'Esperante', 'odio justo', 'Khaki', 'Blue', 577723.08, 143311, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WA1WMAFEXFD896925', 1997, 'Pontiac', 'Sunfire', 'suscipit', 'Crimson', 'Goldenrod', 884160.74, 48165, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1FMJK1JT9FE059081', 2003, 'Honda', 'Civic', 'sit amet', 'Purple', 'Puce', 208166.91, 89173, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBABD33436P160237', 2002, 'GMC', 'Yukon', 'iaculis', 'Mauv', 'Mauv', 618862.66, 82055, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBS3C9C56FJ201784', 1995, 'Dodge', 'Avenger', 'massa id', 'Maroon', 'Purple', 293249.41, 29469, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3LNHL2GC5AR721305', 2001, 'Isuzu', 'Trooper', 'velit donec', 'Red', 'Pink', 425644.19, 38769, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1D7RE3GK5BS427009', 2001, 'Toyota', 'Tundra', 'id consequat', 'Purple', 'Orange', 674522.58, 67063, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('SALCP2BG0FH790224', 1999, 'Honda', 'Civic', 'erat volutpat', 'Orange', 'Maroon', 990499.55, 129118, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G6DP5E31D0990792', 1997, 'Infiniti', 'I', 'elementum', 'Red', 'Green', 190093.92, 131338, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('5TDDK4CC0AS371442', 1992, 'Mercury', 'Tracer', 'etiam vel', 'Orange', 'Green', 619990.35, 122488, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1B3CB1HA0BD555666', 1992, 'Land Rover', 'Defender', 'vestibulum', 'Red', 'Aquamarine', 542195.7, 81068, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3D4PG7FG8BT290777', 2008, 'Volvo', 'C70', 'id', 'Khaki', 'Teal', 721237.88, 88870, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1N4AL3AP2EC273042', 2001, 'Mercury', 'Cougar', 'vel', 'Maroon', 'Aquamarine', 802794.08, 72117, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUHE78P99A584823', 1997, 'GMC', 'Yukon', 'rutrum', 'Mauv', 'Yellow', 911968.02, 39716, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G6DM57N340860827', 2002, 'Dodge', 'Neon', 'pede malesuada', 'Green', 'Yellow', 279027.69, 4746, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('5UXZV4C5XD0316162', 1997, 'Jaguar', 'XJ Series', 'amet diam', 'Turquoise', 'Khaki', 110283.03, 84254, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBAKF3C5XBE396568', 2010, 'BMW', '7 Series', 'nullam porttitor', 'Pink', 'Pink', 317169.34, 49666, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1N4AB7AP9DN822863', 1994, 'Chevrolet', '2500', 'risus', 'Pink', 'Red', 13013.53, 14200, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('SCBBP9ZA7DC142597', 2008, 'Dodge', 'Ram', 'maecenas tincidunt', 'Blue', 'Green', 260450.55, 137747, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('4T1BF3EK3AU797367', 2011, 'Porsche', 'Cayman', 'ligula', 'Teal', 'Puce', 557434.1, 25966, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3C3CFFBR1FT770928', 2012, 'Kia', 'Sportage', 'donec semper', 'Teal', 'Violet', 299955.31, 4639, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3D73M3HL7BG577288', 1988, 'Ford', 'Ranger', 'quam', 'Mauv', 'Indigo', 826235.09, 66365, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2C4RDGCG6CR101910', 1997, 'Mercedes-Benz', 'SL-Class', 'maecenas ut', 'Khaki', 'Crimson', 309273.1, 81921, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3GYFNDEY7AS230088', 1999, 'Pontiac', 'Grand Am', 'mi integer', 'Maroon', 'Green', 575486.39, 41082, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUAC68D31A811290', 1981, 'Dodge', 'Aries', 'sapien', 'Turquoise', 'Purple', 971643.36, 108510, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3D7TP2CT0BG469832', 1995, 'Mazda', 'MX-3', 'scelerisque', 'Puce', 'Orange', 245324.19, 124867, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBA3A5C50DJ770761', 1993, 'Ford', 'LTD Crown Victoria', 'orci', 'Khaki', 'Violet', 210426.7, 77387, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2HNYD28307H720447', 1995, 'Ford', 'Crown Victoria', 'pulvinar', 'Green', 'Goldenrod', 996799.58, 89652, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('5XYKT3A17CG731421', 2008, 'Volkswagen', 'Touareg', 'velit', 'Crimson', 'Crimson', 571171.09, 120259, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G4HD57286U388653', 1995, 'Porsche', '928', 'mi in', 'Violet', 'Yellow', 290405.62, 143630, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JN8AZ1MU0DW747103', 1993, 'Ford', 'Ranger', 'pharetra magna', 'Maroon', 'Teal', 16469.16, 30477, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1FTEW1CM2BF073523', 2007, 'Isuzu', 'i-290', 'ante', 'Red', 'Purple', 646501.54, 5413, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1C3CDFDH3ED274060', 2001, 'Lincoln', 'LS', 'condimentum', 'Puce', 'Maroon', 412520.73, 41814, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('KM8JT3AB0CU281061', 1994, 'Honda', 'Passport', 'ipsum primis', 'Yellow', 'Purple', 507759.43, 95943, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUCFAFH5EN077811', 1992, 'Ford', 'Ranger', 'primis', 'Fuscia', 'Maroon', 592489.23, 104187, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2HNYD28698H883495', 2000, 'Toyota', 'Echo', 'tortor', 'Purple', 'Pink', 572583.96, 130234, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('YV4852CT6B1282693', 1988, 'Ford', 'Taurus', 'ut nunc', 'Blue', 'Blue', 972633.65, 59654, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JTHBP5C25E5537079', 1997, 'GMC', 'Sonoma Club Coupe', 'nec nisi', 'Teal', 'Maroon', 814297.98, 130469, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3VW467AT1CM401265', 2007, 'Buick', 'Rainier', 'in imperdiet', 'Goldenrod', 'Khaki', 23234.01, 26652, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1FTFW1E8XAK001852', 1994, 'Pontiac', 'Bonneville', 'ac leo', 'Yellow', 'Mauv', 269512.23, 123923, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G6DS57V590144623', 2008, 'Nissan', 'Titan', 'et', 'Teal', 'Teal', 773815.91, 100657, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G6DP5ED5B0937065', 1994, 'Isuzu', 'Trooper', 'quis', 'Puce', 'Blue', 598969.49, 27870, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBA3N3C52EK749091', 1992, 'Suzuki', 'Sidekick', 'eros viverra', 'Yellow', 'Turquoise', 470172.34, 28160, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1GD220CG0CZ075689', 2010, 'Volkswagen', 'Eos', 'nisi', 'Violet', 'Khaki', 482466.28, 13890, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WP0CA2A84ES525925', 2011, 'GMC', 'Yukon', 'vestibulum sed', 'Maroon', 'Orange', 616057.43, 83230, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBAUC9C54DV974171', 1989, 'Mercedes-Benz', 'E-Class', 'congue etiam', 'Turquoise', 'Purple', 31680.8, 130744, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WVGAV7AX9FW402885', 2009, 'Volkswagen', 'Touareg', 'velit', 'Fuscia', 'Green', 845886.52, 135805, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3GYT4LEF6CG286799', 1992, 'Cadillac', 'Eldorado', 'vestibulum rutrum', 'Turquoise', 'Aquamarine', 758885.59, 115554, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1N4AL2AP4AC224848', 1992, 'Geo', 'Metro', 'cursus id', 'Pink', 'Yellow', 267267.22, 2433, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1D7RB1GT8BS835543', 1992, 'Hyundai', 'Sonata', 'lorem vitae', 'Teal', 'Orange', 923252.33, 17216, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WVWAP7AN5EE794751', 2011, 'Toyota', 'Venza', 'natoque', 'Fuscia', 'Yellow', 519303.37, 89611, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('YV1382MS6A2648990', 2000, 'GMC', 'Savana 1500', 'integer non', 'Pink', 'Yellow', 539103.75, 135580, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUKH94F57N070057', 1993, 'Nissan', 'Quest', 'ullamcorper', 'Aquamarine', 'Puce', 548503.85, 104376, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JN8AZ2KR7CT952826', 2004, 'Jeep', 'Liberty', 'accumsan tortor', 'Indigo', 'Turquoise', 899568.88, 57292, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G6AZ5SX1F0812081', 1998, 'Audi', 'A6', 'quisque', 'Yellow', 'Indigo', 110201.41, 147860, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WVWED7AJ4DW407154', 2009, 'Pontiac', 'G3', 'feugiat et', 'Yellow', 'Puce', 910303.47, 147775, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3VW1K7AJ9BM343580', 1997, 'Dodge', 'Ram 2500', 'commodo', 'Khaki', 'Turquoise', 342080.23, 65668, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JH4CW2H57BC978745', 1998, 'Nissan', 'Quest', 'lacinia eget', 'Orange', 'Indigo', 43227.66, 130306, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBABN73463P692176', 1985, 'Subaru', 'Brat', 'pellentesque volutpat', 'Red', 'Purple', 230209.82, 97468, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WUAUUAFG0EN387694', 1984, 'Pontiac', 'Sunbird', 'non mauris', 'Goldenrod', 'Turquoise', 676191.73, 114930, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUNF68P16A642588', 1995, 'Toyota', 'T100', 'consectetuer adipiscing', 'Maroon', 'Goldenrod', 287613.88, 63699, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2C3CCAEG7DH559132', 1995, 'Toyota', 'Tercel', 'massa', 'Maroon', 'Indigo', 653375.0, 101761, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2B3CJ5DT2BH023646', 1992, 'Mercedes-Benz', '300D', 'et commodo', 'Violet', 'Goldenrod', 180974.82, 28174, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUVFAFR4AA304179', 1988, 'Pontiac', 'LeMans', 'nulla eget', 'Puce', 'Khaki', 62472.73, 64050, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('19XFA1E56BE897773', 2004, 'Toyota', 'Solara', 'sed sagittis', 'Purple', 'Pink', 411563.5, 15691, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JA4AS2AW9CU150404', 1995, 'Oldsmobile', 'Aurora', 'dapibus at', 'Turquoise', 'Goldenrod', 637621.89, 36534, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBAUN9C51AV067786', 1984, 'Ford', 'F250', 'eros', 'Turquoise', 'Khaki', 387033.21, 86498, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WVGEP9BP0FD365081', 2005, 'Mercedes-Benz', 'SL-Class', 'praesent', 'Blue', 'Red', 122382.12, 120111, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBA3D5C50EK944315', 2009, 'Pontiac', 'G5', 'in faucibus', 'Violet', 'Goldenrod', 827944.85, 10375, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WA1WYBFE5AD781183', 1970, 'Dodge', 'Charger', 'morbi', 'Orange', 'Mauv', 477033.55, 145958, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1N6AA0EC0DN371864', 1985, 'Mazda', 'RX-7', 'magna bibendum', 'Mauv', 'Crimson', 877968.67, 122275, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JN8AZ2NC4B9157395', 1999, 'BMW', '5 Series', 'nunc nisl', 'Goldenrod', 'Blue', 667598.84, 25420, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1G6DL1E38C0301981', 1964, 'Pontiac', 'GTO', 'nec euismod', 'Fuscia', 'Pink', 22081.78, 43254, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAULD54B43N272095', 1991, 'Volkswagen', 'Jetta', 'libero', 'Fuscia', 'Blue', 661022.26, 108170, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1GD21ZCGXBZ312288', 2004, 'Jeep', 'Grand Cherokee', 'sapien', 'Pink', 'Violet', 197851.32, 102310, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JTDKN3DP7E3263868', 2001, 'Plymouth', 'Neon', 'praesent blandit', 'Maroon', 'Blue', 350269.39, 147435, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAULT58E65A036646', 1996, 'Chevrolet', '2500', 'egestas', 'Goldenrod', 'Yellow', 269969.81, 62748, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2G4WY55J221544469', 2005, 'Mitsubishi', 'Endeavor', 'pede', 'Puce', 'Teal', 114064.83, 90729, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUCFAFH8BN993412', 1997, 'Chevrolet', 'Corvette', 'quisque', 'Pink', 'Maroon', 979745.16, 107258, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JH4KC1F52FC282785', 2009, 'Mercedes-Benz', 'R-Class', 'blandit non', 'Purple', 'Puce', 863148.07, 8853, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('2C3CCABG4CH209816', 2004, 'Oldsmobile', 'Alero', 'magna bibendum', 'Crimson', 'Orange', 86907.44, 11763, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('5N1AN0NUXBC708884', 2012, 'Ford', 'Fiesta', 'sed ante', 'Fuscia', 'Teal', 796538.59, 9170, '4-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3N1CE2CP5FL421696', 1997, 'Jaguar', 'XK Series', 'lectus vestibulum', 'Khaki', 'Mauv', 93124.46, 71175, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1C3BC4FB7BN090550', 1997, 'Honda', 'Odyssey', 'quis', 'Crimson', 'Khaki', 37491.73, 62364, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('JN1AZ4EH6EM326629', 1995, 'Volvo', '850', 'mi nulla', 'Crimson', 'Indigo', 954719.55, 112315, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3MZBM1U74EM280419', 1996, 'Chevrolet', 'Suburban 1500', 'semper', 'Indigo', 'Puce', 918903.98, 98549, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUAFAFH2DN425411', 1998, 'Pontiac', 'Grand Prix', 'ultricies eu', 'Violet', 'Crimson', 42990.91, 110560, '4WD Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('SCFEBBBK4BG527951', 2008, 'Lexus', 'IS-F', 'sit', 'Goldenrod', 'Puce', 453801.45, 13751, '6-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1N4CL2AP6BC191183', 2005, 'GMC', 'Canyon', 'nam', 'Purple', 'Pink', 905607.83, 82186, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1N4AL3AP9EC751974', 2006, 'Honda', 'Element', 'blandit', 'Maroon', 'Violet', 43168.33, 132182, 'UNSPECIFIED');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('SALAB2V64FA009125', 2005, 'Chevrolet', 'Impala', 'lacus curabitur', 'Pink', 'Violet', 319901.27, 85753, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('3C3CFFAR2CT968480', 2010, 'Smart', 'Fortwo', 'integer', 'Green', 'Maroon', 474131.2, 1765, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WBA6B2C59FD965980', 2001, 'Ford', 'Escort', 'nulla', 'Turquoise', 'Mauv', 451346.87, 53020, '5-Speed Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1D7RV1CP2AS961556', 2006, 'Toyota', 'Solara', 'montes nascetur', 'Orange', 'Blue', 555009.8, 103584, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('WAUMF78K49A481096', 1988, 'Acura', 'Integra', 'at', 'Orange', 'Teal', 577475.25, 105379, 'Automatic');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('SAJWA0F79F8176309', 1996, 'Suzuki', 'Swift', 'bibendum imperdiet', 'Red', 'Violet', 523201.89, 28874, 'Manual');
            insert into inventory (VIN, YEAR, Make, Model, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, MILEAGE, TRANSMISSION) values ('1GD21ZCG5BZ826940', 1991, 'Volkswagen', 'Cabriolet', 'adipiscing lorem', 'Aquamarine', 'Puce', 499178.52, 76445, 'Manual'); ";

             if ($mysqli->multi_query($sql)) {
        // Clear the 100+ result sets so the connection stays open
        while ($mysqli->next_result()) { ; } 
        echo "<h3>✅ Setup Complete!</h3>";
    } else {
        echo "<h3>❌ Error: " . $mysqli->error . "</h3>";
    }

    echo "<a href='index.php'>Return to Home</a>";
    exit(); 
}

$message = "";
$edit_car = null;

// --- Updated Save Logic (To handle new fields) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_car'])) {
    $vin = $mysqli->real_escape_string($_POST['VIN']);
    $year = (int)$_POST['Year'];
    $make = $mysqli->real_escape_string($_POST['Make']);
    $model = $mysqli->real_escape_string($_POST['Model']);
    $trim = $mysqli->real_escape_string($_POST['Trim']);
    $price = (float)$_POST['Asking_Price'];
    $color = $mysqli->real_escape_string($_POST['Color']);
    $mileage = (int)$_POST['Mileage'];
    $int_color = $mysqli->real_escape_string($_POST['Interior']);
    $trans = $mysqli->real_escape_string($_POST['Transmission']);

if ($_POST['is_update'] == "1") {
    $query = "UPDATE inventory SET 
    YEAR=$year, 
    Make='$make', 
    Model='$model', 
    TRIM='$trim', 
    ASKING_PRICE=$price, 
    EXT_COLOR='$color', 
    INT_COLOR='$int_color',
    MILEAGE=$mileage,
    TRANSMISSION='$trans'
    WHERE VIN='$vin'";
} else {
    $query = "INSERT INTO inventory 
    (VIN, YEAR, Make, Model, TRIM, ASKING_PRICE, EXT_COLOR, INT_COLOR, MILEAGE, TRANSMISSION) 
    VALUES 
    ('$vin', $year, '$make', '$model', '$trim', $price, '$color', '$int_color', $mileage, '$trans')";
}

if ($mysqli->query($query)) {
    header("Location: index.php?msg=Saved+successfully");
} else {
    header("Location: index.php?msg=Error+saving");
}
exit();

}


// 1. DELETE LOGIC
if (isset($_GET['delete']) && isset($_SESSION['username'])) {
    $vin = $mysqli->real_escape_string($_GET['delete']);
    $mysqli->query("DELETE FROM inventory WHERE VIN='$vin'");
    header("Location: index.php?msg=Deleted");
    exit();
}

// 2. EDIT MODE (Fetch data for pre-population)
if (isset($_GET['edit']) && isset($_SESSION['username'])) {
    $vin = $mysqli->real_escape_string($_GET['edit']);
    $res = $mysqli->query("SELECT * FROM inventory WHERE VIN = '$vin'");
    $edit_car = $res->fetch_assoc();
}


if (isset($_GET['msg'])) $message = $_GET['msg'];
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
            <?php if (isset($_SESSION['username'])): ?>
    <p>
        Welcome, <?php echo $_SESSION['username']; ?> |
        <a href="?logout=true">Logout</a>
    </p>

    <div style="background:#ffdddd; padding:15px; border:2px solid red; margin-bottom:20px;">
        <strong>⚠ WARNING ⚠</strong><br>
        Running setup will DELETE ALL DATA.<br><br>
        <a href="?run_setup=true" onclick="return confirm('THIS WILL DELETE EVERYTHING. CONTINUE?')">
            Run Setup Script
        </a>
    </div>
<?php endif; ?>


            <?php if ($message): ?>
                <div class="msg-success"><h3><?php echo htmlspecialchars($message); ?></h3></div>
            <?php endif; ?>

            <!-- Login Form, Showed When Logged Out -->
            <?php if (!isset($_SESSION['username'])): ?>
            <section class="form-section">
                <h2>Login</h2>
                <form method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login" class="btn-submit">Login</button>
                </form>
            </section>
            <?php endif; ?>

            <!-- COMBINED FORM: INSERT & UPDATE -->
             <?php if (isset($_SESSION['username'])): ?>
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
            <?php endif; ?>

            <!-- VIEW SECTION -->
            <table>
                <thead>
                    <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Asking Price</th>
                        <th>Year</th>
                        <th>Trim</th>
                        <th>Color</th>
                        <th>Mileage</th>
                        <th>Transmission</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $inventory->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['Make']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['Model']); ?></td>
                        <td>$<?php echo number_format($row['ASKING_PRICE'], 0); ?></td>
                        <td><?php echo $row['YEAR']; ?></td>
                        <td><?php echo $row['TRIM']; ?></td>
                        <td><?php echo $row['EXT_COLOR']; ?></td>
                        <td><?php echo $row['MILEAGE']; ?></td>
                        <td><?php echo $row['TRANSMISSION']; ?></td>
                        <td>
<?php if (isset($_SESSION['username'])): ?>
    <a href="?edit=<?php echo $row['VIN']; ?>" class="btn-edit">Edit</a>
    <a href="?delete=<?php echo $row['VIN']; ?>" class="btn-del" onclick="return confirm('Delete this vehicle?')">Delete ❌</a>
<?php else: ?>
    <span style="color:gray;">Login to edit</span>
<?php endif; ?>
</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <div class="pagination" style="margin: 20px 0; text-align: center;">
            <strong>Pages: </strong>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?p=<?php echo $i; ?>" 
            style="padding: 5px 10px; margin: 0 2px; border: 1px solid #ccc; text-decoration: none; <?php echo ($page == $i) ? 'background: #ddd; font-weight: bold;' : ''; ?>">
            <?php echo $i; ?>
            </a>
            <?php endfor; ?>
        </div>

        </main>

        <footer>
            <p>Designed by Soto Air Design Co. | Don't sue us just because we use gum to hold our cars together.</p>
        </footer>
    </div>
</body>
</html>
