<?php

session_start();

require 'functions.php';

$link = getDbConnection();

if (empty($_SESSION['user'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

//print_r($categories);

if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $errors = [];
    $photoLot = [];

    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = strip_tags($value);

            if (empty($value)) {
                $errors[$key] = 'Заполните это поле';
                continue;
            }

            if (in_array($key, ['lot-rate', 'lot-step']) && !filter_var($value, FILTER_VALIDATE_INT)) {
                $errors[$key] = 'Введите число';
            }
        }

        if (isset($_FILES['uploadfile'])) {
            $photoLot = $_FILES['uploadfile'];

            if ($photoLot['type'] == 'image/jpeg') {
                move_uploaded_file($photoLot['tmp_name'], 'img/' . $photoLot['name']);
            } else {
                $errors['uploadfile'] = 'Неверный формат!';
            }
        }

        if (empty($errors)) {
            list($lot_name, $category_post, $description, $initial_price, $step_bet, $completion_date) = array_values($_POST);
            $completion_date = date("Y-m-d H:i:s", strtotime($completion_date));
            $user_id = $_SESSION['user']['id'];
            $image = '/img/' . $_FILES['uploadfile']['name'];
            $category_id = '';
            foreach ($categories as $category) {
                if ($category['name'] == $category_post) {
                    $category_id = $category['id'];
                    break;
                }
            }
            $data = [$completion_date, $lot_name, $description, $image, $initial_price, $step_bet, $user_id, $category_id];

            $sql = "INSERT INTO lots (created_date, completion_date, name, description, image, initial_price, step_bet, user_id, category_id)"
                ."VALUE (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

            $get_id[] = insertData($link, $sql, $data);


            $sql = "SELECT created_date, amount, bets.user_id, bets.lot_id, users.name AS name FROM bets"
                ." JOIN users ON bets.user_id = users.id WHERE bets.lot_id = ?"
                ." ORDER BY created_date DESC";
            $bets = receivingData($link, $sql, $get_id);

            if ($bets) {
                $price =  $bets[0]['amount'];
            } else {
                $price = $initial_price;
            }

            $lot = [
                "lot_name" => $lot_name,
                "category" => $category_post,
                "completion_date" => $completion_date,
                "price" => $price,
                "image" => $image,
                "description" => $description,
                "step" => $step_bet
            ];
        }

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

<?php if (empty($_POST) || !empty($errors)) : ?>

    <?= includeTemplate('add_lot.php', ['errors' => $errors, 'photoLot' => $photoLot, 'categories' => $categories]); ?>

<?php else : ?>

    <?= includeTemplate('lot_content.php', ['bets' => $bets, 'lot' => $lot, 'price' => $initial_price, 'categories' => $categories]); ?>

<?php endif; ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>
