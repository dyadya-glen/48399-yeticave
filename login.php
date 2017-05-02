<?php

session_start();

require 'functions.php';

include 'userdata.php';

$errors = [];

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = strip_tags($value);

        if (empty($value)) {
            $errors[$key] = 'Заполните это поле';
            continue;
        }
    }

    if (empty($errors)) {
        $user_found = false;

        foreach ($users as $user) {
            if ($_POST['email'] == $user['email']) {
                $user_found = true;

                if (password_verify($_POST['password'], $user['password'])) {
                    $_SESSION['user'] = $user;

                    header("Location: /");
                    exit();
                } else {
                    $errors['password'] = "Не верный пароль!";
                }
                break;
            }
        }
        if (!$user_found) {
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

<?= includeTemplate('header.php', []); ?>

<?= includeTemplate('login.php', ['errors' => $errors]); ?>

<?= includeTemplate('footer.php', []); ?>

</body>
</html>