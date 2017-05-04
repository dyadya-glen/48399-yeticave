<?php

session_start();

require 'functions.php';

include 'data.php';

$lot_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!array_key_exists($lot_id, $bulletin_board)) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

$my_bets = getBetsList();

if (!empty($_POST['cost']) && filter_var($_POST['cost'], FILTER_VALIDATE_INT)) {
    $my_bets[] = [
        'cost' => $_POST['cost'],
        'lot_id' => $lot_id,
        'time' => time(),
    ];

    $my_bets = json_encode($my_bets);
    setcookie("my_bets", $my_bets, strtotime("+30 days"));
    header("Location: /mylots.php");
    exit();
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
    'bets' => $bets,
    'lot' => $bulletin_board[$lot_id],
    'is_lot_has_bet' => isLotHasBet($lot_id, $my_bets)
]); ?>

<?= includeTemplate('footer.php'); ?>

</body>
</html>
