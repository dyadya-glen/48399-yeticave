<?php

session_start();

require 'functions.php';

if (empty($_SESSION['user'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$link = getDbConnection();

$my_bets = getBetsList();

if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $sql = "SELECT bets.created_date,
                   amount,
                   lot_id,
                   lots.image AS lot_image,
                   lots.name AS lot_name,
                   lots.completion_date AS lot_completion_date,
                   categories.name AS category
            FROM bets
            JOIN lots ON lots.id = bets.lot_id
            JOIN categories ON categories.id = lots.category_id
            WHERE bets.user_id = ?";

    $my_bets = receivingData($link, $sql, [$_SESSION['user']['id']]);
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

<?= includeTemplate('mylots.php', ['my_bets' => $my_bets, 'categories' => $categories]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>
