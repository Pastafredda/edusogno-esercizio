<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="assets/styles/header.css">
        <link rel="stylesheet" href="assets/styles/style.css">

    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <img src="./images/logo.png" alt="">
                </div>
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['role'])): ?>
                <a href="logout.php" class="logout-button">Logout</a>
                <?php endif; ?>
            </div>
        </header>
    </body>
</html>