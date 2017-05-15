<?php

session_start();

require 'functions.php';

$link = getDbConnection();

if (!$link) {
    header('HTTP/1.1 500 Internal Server Error');
    print('Ошибка подключения: ' . mysqli_connect_error());
    die();

} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $sql = "SELECT lots.id, completion_date, lots.name AS lot_name, categories.name AS category, description, image, initial_price FROM lots "
        . "JOIN categories ON lots.category_id = categories.id "
        . "ORDER BY created_date DESC LIMIT 6";
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

<?= includeTemplate('main.php', ['categories' => $categories, 'bulletin_board' => $bulletin_board]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>