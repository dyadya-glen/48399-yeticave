<?php

session_start();

require 'functions.php';

include 'data.php';

$my_bets = getBetsList();

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

<?= includeTemplate('header.php'); ?>

<?= includeTemplate('mylots.php', ['bulletin_board' => $bulletin_board, 'my_bets' => $my_bets]); ?>

<?= includeTemplate('footer.php'); ?>

</body>
</html>
