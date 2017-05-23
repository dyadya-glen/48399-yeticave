<?php

require_once 'bootstrap.php';

$lot_id = isset($_GET['id']) ? intval($_GET['id']) : null;

$sql = "SELECT lots.id,
               completion_date,
               lots.name AS lot_name,
               categories.name AS category,
               description,
               image,
               initial_price,
               step_bet AS step,
               user_id
        FROM lots
        JOIN categories ON lots.category_id = categories.id
        WHERE lots.id = ?";

$bulletin_board = $data_base->receivingData($sql, [$lot_id]);

if (!isset($bulletin_board[0])) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

$sql = "SELECT created_date, amount, bets.user_id, bets.lot_id, users.name AS name FROM bets"
    ." JOIN users ON bets.user_id = users.id WHERE bets.lot_id = ?"
    ." ORDER BY created_date DESC";
$bets = $data_base->receivingData($sql, [$lot_id]);


$lot = $bulletin_board[0];

if ($bets) {
    $price =  $bets[0]['amount'];
} else {
    $price = $lot['initial_price'];
}

$user_id = $auth_user->getDataUser()['id'];

if ($auth_user->isAuthorized()) {

    $sql = "SELECT amount AS cost, lot_id, created_date AS time FROM bets WHERE bets.user_id = ?";
    $my_bets = $data_base->receivingData($sql, [$user_id]);

    if (!empty($_POST['cost']) && filter_var($_POST['cost'], FILTER_VALIDATE_INT)) {
        $bet = [
            'cost' => $_POST['cost'],
            'user_id' => $user_id,
            'lot_id' => $lot_id,
        ];

        $sql = "INSERT INTO bets (`created_date`, `amount`, `user_id`, `lot_id`) VALUE (NOW(), ?, ?, ?)";
        $data_base->insertData($sql, $bet);

        header("Location: /mylots.php");
        exit();
    }
} else {
    $my_bets = [];
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

<?= includeTemplate(
    'header.php',
    [
        'is_authorized' => $auth_user->isAuthorized(),
        'user' => $auth_user->getDataUser()
    ]
); ?>

<?= includeTemplate(
    'lot_content.php',
    [
        'categories' => $categories,
        'bets' => $bets,
        'lot' => $lot,
        'price' => $price,
        'is_lot_has_bet' => isLotHasBet($lot_id, $my_bets),
        'is_authorized' => $auth_user->isAuthorized(),
        'user_id' =>$user_id
    ]
); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>
