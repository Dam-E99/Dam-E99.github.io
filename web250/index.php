<?php
$page = $_GET['page'] ?? 'home';
$site_name = "Danny Soto Duarte's Dazzling Dodo 🐾 WEB250";

switch ($page) {
    case 'introduction':
        $title = "$site_name Introduction";
        $content = 'introduction.php';
        break;

    case 'contract':
        $title = "$site_name Contract";
        $content = 'contract.php';
        break;

    case 'projects':
        $title = "$site_name Projects";
        $content = 'projects.php';
        break;

    default:
        $title = "$site_name Home";
        $content = 'home.php';
}
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
            <a href="multipage_sites/superduper_static/index.htm" target="_blank">Multipage Static</a>
            |
            <a href="multipage_sites/superduper_php/index.php" target="_blank">Multipage PHP</a>
        </nav>
    </header>

    <main>
        <?php include "contents/$content"; ?>
    </main>
   
    <footer>
        <nav>
            <a href="https://github.com/Dam-E99">GitHub</a>
            |
            <a href="https://dam-e99.github.io/" target="_blank">GitHub.io</a>
            |
            <a href="https://dam-e99.github.io/web250/index.html">WEB250.io</a>
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
