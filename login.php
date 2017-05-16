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
}

$errors = [];

if (!empty($_POST)) {
    $errors = checkEmptyPost($_POST);

    if (empty($errors)) {
        $user = searchUserByEmail($link, $_POST['email']);

        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;

                header("Location: /");
                exit();
            } else {
                $errors['password'] = "Не верный пароль!";
            }
        } else {
            $errors['email'] = "Пользователь не найден!";
        }
    }
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

<?= includeTemplate('login.php', ['categories' => $categories, 'errors' => $errors]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>