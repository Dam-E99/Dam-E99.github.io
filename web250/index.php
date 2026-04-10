<?php
$page = $_GET['page'] ?? 'home';
$site_name = "Danny Soto Duarte's Dazzling Dodo 🐾 WEB250";

$allowed_pages = [
    'home'         => 'home.php',
    'introduction' => 'introduction.php',
    'contract'     => 'contract.php',
    'projects'     => 'projects.php'
];

$content = $allowed_pages[$page] ?? 'home.php';

$title = $site_name . " " . ucfirst($page);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/default.css" />
    <script src="https://lint.page/kit/880bd5.js" crossorigin="anonymous"></script>
    <title> <?= $title ?> </title>
</head>
<body>
    <header>
        <h1>Danny Soto Duarte's Dazzling Dodo - WEB250</h1>
        <nav>
            <a href="index.php?page=home">Home</a>
            |
            <a href="index.php?page=introduction">Introduction</a>
            |
            <a href="index.php?page=contract">Contract</a>
            |
            <a href="fizzbuzz.html">FizzBuzz</a>
        </nav>
        <nav>
            <a href="multipage_sites/superduper_static/index.htm" target="_blank">MP Static</a>
            |
            <a href="multipage_sites/superduper_php/index.php" target="_blank">MP PHP</a>
            |
            <a href="joyofphp/src/index.php" target="_blank">Joy of Php</a>
            |
            <a href="joyofphp/src/samsusedcars.html" target="_blank">Sam's Used Cars</a>
            |
            <a href="carapp/index.php" target="_blank">Dodo's Car Lite</a>
            |
            <a href="carapp2/index.php" target="_blank">Dodo's Car Pro</a>
        </nav>
    </header>

    <main>
        <?php include "contents/$content"; ?>
    </main>
   
    <footer>
        <nav>
            <a href="https://github.com/Dam-E99" target="_blank">GitHub</a>
            |
            <a href="https://dam-e99.github.io/" target="_blank">GitHub.io</a>
            |
            <a href="https://dam-e99.github.io/web250/index.html" target="_blank">WEB250.io</a>
            |
            <a href="/web215/index.html" target="_blank">WEB215.io</a>
            |
            <a href="https://www.freecodecamp.org/dame99" target="_blank">freeCodeCamp</a>
            |
            <a href="https://www.codecademy.com/profiles/dsotodu0" target="_blank">Codecademy</a>
            |
            <a href="https://www.linkedin.com/in/danny-soto-duarte-ab9744296" target="_blank">LinkedIn</a>
            <p>© 2026 Danny Soto Duarte</p>
        </nav>
    </footer>


</body>
</html>
