<?php

session_start();

require 'functions.php';

include 'data.php';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('header.php', []); ?>

<?= includeTemplate('main.php', ['categories' => $categories, 'bulletin_board' => $bulletin_board]); ?>

<?= includeTemplate('footer.php', []); ?>

</body>
</html>