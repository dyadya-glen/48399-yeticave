<?php

session_start();

require 'functions.php';

include 'userdata.php';

$errors = [];

if (!empty($_POST)) {
    $errors = checkEmptyPost($_POST);


    if (empty($errors)) {
        $user = searchUserByEmail($_POST['email'], $users);

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

<?= includeTemplate('login.php', ['errors' => $errors]); ?>

<?= includeTemplate('footer.php'); ?>

</body>
</html>