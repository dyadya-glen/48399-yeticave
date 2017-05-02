<?php

session_start();

require 'functions.php';

include 'data.php';

$lot_id = intval($_GET['id']);

if (!array_key_exists($lot_id, $bulletin_board)) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

$lot = $bulletin_board[$lot_id];

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DC Ply Mens 2016/2017 Snowboard</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('header.php', []); ?>

<?= includeTemplate('lot_content.php', ['bets' => $bets, 'lot' => $lot]); ?>

<?= includeTemplate('footer.php', []); ?>

</body>
</html>
