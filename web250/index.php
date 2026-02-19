<?php
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'introduction':
        $title = 'Introduction';
        $content = 'introduction.php';
        break;

    case 'contract':
        $title = 'Contract';
        $content = 'contract.php';
        break;

    default:
        $title = 'Home';
        $content = 'home.php';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/default.css" />
    <title> <?= $title ?> | Danny Soto Duarte's Dazzling Dodo </title>
</head>
<body>
    <header>
        <h1>WEB250</h1>
        <nav>
            <a href="index.php?page=home">Home</a>
            |
            <a href="index.php?page=introduction">Introduction</a>
            |
            <a href="index.php?page=contract">Contract</a>
            |
            <a href="multipage_sites/superduper_static/index.htm">Multipage Static</a>
            |
            <a href="multipage_sites/superduper_php/index.php">Multipage PHP</a>
        </nav>
    </header>

    <main>
        <?php include "contents/$content"; ?>
    </main>
   
    <footer>
        <nav>
            <a href="https://dam-e99.github.io/">Github Pages</a>
            |
            <a href="https://github.com/Dam-E99" target="_blank">Github Account</a>
            |
            <a href="https://www.freecodecamp.org/dame99" target="_blank">freeCodeCamp</a>
            |
            <a href="https://www.codecademy.com/profiles/dsotodu0" target="_blank">Codecademy</a>
            |
            <a href="https://www.linkedin.com/in/danny-soto-duarte-ab9744296" target="_blank">LinkedIn</a>
        </nav>
    </footer>


</body>
</html>
