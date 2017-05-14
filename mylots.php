<?php

session_start();

require 'functions.php';

$link = getDbConnection();

$my_bets = getBetsList();

if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $sql = "SELECT lots.id, completion_date, lots.name AS lot_name, categories.name AS category, description, image, initial_price, step_bet AS step FROM lots"
        . " JOIN categories ON lots.category_id = categories.id";

    $bulletin_board = receivingData($link, $sql);
}

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

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>
