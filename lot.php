<?php

session_start();

require 'functions.php';

$link = getDbConnection();

$lot_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $sql = "SELECT lots.id, completion_date, lots.name AS lot_name, categories.name AS category,"
        ." description, image, initial_price, step_bet AS step FROM lots"
        ." JOIN categories ON lots.category_id = categories.id WHERE lots.id = ?";

    $get_id[] =  $lot_id;

    $bulletin_board = receivingData($link, $sql, $get_id);

    $sql = "SELECT created_date, amount, bets.user_id, bets.lot_id, users.name AS name FROM bets"
        ." JOIN users ON bets.user_id = users.id WHERE bets.lot_id = ?"
        ." ORDER BY created_date DESC";
    $bets = receivingData($link, $sql, $get_id);

    $lot = $bulletin_board[0];

    if (!($lot_id == $lot['id'])) {
        header('HTTP/1.1 404 Not Found');
        exit();
    }

    if ($bets) {
        $price =  $bets[0]['amount'];
    } else {
        $price = $lot['initial_price'];
    }

    $my_bets = getBetsList();

    if (!empty($_POST['cost']) && filter_var($_POST['cost'], FILTER_VALIDATE_INT)) {
        $my_bets[] = [
            'cost' => $_POST['cost'],
            'lot_id' => $lot_id,
            'time' => time(),
        ];

        $my_bets = json_encode($my_bets);
        setcookie("my_bets", $my_bets, strtotime("+1 days"));
        header("Location: /mylots.php");
        exit();
    }
}
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

<?= includeTemplate('header.php'); ?>

<?= includeTemplate('lot_content.php', [
                                                'categories' => $categories,
                                                'bets' => $bets,
                                                'lot' => $lot,
                                                'price' => $price,
                                                'is_lot_has_bet' => isLotHasBet($lot_id, $my_bets)
                                                ]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>
