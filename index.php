<?php

session_start();

require 'functions.php';

$link = getDbConnection();

if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $sql = 'SELECT lots.id, lots.name AS lot_name, categories.name AS category, description, image, initial_price FROM lots'
        .' JOIN categories ON lots.category_id = categories.id'
        .' ORDER BY created_date DESC LIMIT 6';
    $bulletin_board = receivingData($link, $sql);
}

// $sql = "INSERT INTO lots (`name`, `category_id`,`created_date`,  `description`, `image`, `initial_price`, `step_bet`, `completion_date`, `user_id`) VALUE (?, ?, NOW(), ?, ?, ?, ?, ?, ?)";

// $data = ["Super-Board 2017", "1", "Эта доска доставит вас к подножью горы в мгновение ока!!!", "/img/lot-7.jpg", "10789", "200", "2017-06-07 13:15:00", "1"];

// insertData($link, $sql, $data);

// $table_name = 'lots';

// $update_data = ['created_date' => '2017-03-07 13:15:00'];

// $where = ['id' => 8];

// updateData($link, $table_name, $update_data, $where);

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