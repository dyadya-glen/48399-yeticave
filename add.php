<?php

session_start();

require 'functions.php';

$link = getDbConnection();

if (empty($_SESSION['user'])) {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!$link) {
    header('HTTP/1.1 500 Internal Server Error');
    print('Ошибка подключения: ' . mysqli_connect_error());
    die();

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
            [
                'lot-name' => $lot_name,
                'category' => $category_id,
                'message' => $description,
                'lot-rate' => $initial_price,
                'lot-step' => $step_bet,
                'completion_date' => $completion_date
            ] = $_POST;

            $completion_date = date("Y-m-d H:i:s", strtotime($completion_date));
            $user_id = $_SESSION['user']['id'];
            $image = '/img/' . $_FILES['uploadfile']['name'];

            $data = [
                $completion_date,
                $lot_name,
                $description,
                $image,
                $initial_price,
                $step_bet,
                $user_id,
                $category_id
            ];

            $sql = "INSERT INTO lots (created_date, completion_date, name, "
                ."description, image, initial_price, step_bet, user_id, category_id)"
                ."VALUE (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

            $lot_id = insertData($link, $sql, $data);

            if ($lot_id > 0) {
                header("Location: /lot.php?id=" . $lot_id);
                exit();
            }
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

<?= includeTemplate('add_lot.php', ['errors' => $errors, 'photoLot' => $photoLot, 'categories' => $categories]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>
