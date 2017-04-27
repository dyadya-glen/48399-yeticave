<?php
// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    [
        'name' => 'Иван',
        'price' => 11500,
        'ts' => strtotime('-' . rand(1, 50) .' minute'),
    ],
    [
        'name' => 'Константин',
        'price' => 11000,
        'ts' => strtotime('-' . rand(1, 18) .' hour'),
    ],
    [
        'name' => 'Евгений',
        'price' => 10500,
        'ts' => strtotime('-' . rand(25, 50) .' hour'),
    ],
    [
        'name' => 'Семён',
        'price' => 10000,
        'ts' => strtotime('last week'),
    ],
];

require 'functions.php';

include 'bulletin_board.php';

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
