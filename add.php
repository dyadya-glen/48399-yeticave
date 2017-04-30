<?php

require 'functions.php';

include 'data.php';

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
        $lot = [
            "name" => $_POST["lot-name"],
            "category" => $_POST["category"],
            "price" => $_POST["lot-rate"],
            "url_image" => 'img/' . $photoLot['name'],
            "description" => $_POST['message'],
        ];

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

<?= includeTemplate('header.php', []); ?>

<?php if (empty($_POST) || !empty($errors)) : ?>

    <?= includeTemplate('add_lot.php', ['errors' => $errors, 'photoLot' => $photoLot, 'categories' => $categories]); ?>

<?php else : ?>

    <?= includeTemplate('lot_content.php', ['bets' => $bets, 'lot' => $lot]); ?>

<?php endif; ?>

<?= includeTemplate('footer.php', []); ?>

</body>
</html>