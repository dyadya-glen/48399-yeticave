<?php

session_start();

require 'functions.php';

$link = getDbConnection();

if (!$link) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = "SELECT * FROM categories";
    $categories = receivingData($link, $sql);

    $sql = "SELECT email FROM users";
    $users = receivingData($link, $sql);

    $errors = [];
    $user_avatar = [];


    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = strip_tags($value);

            if (empty($value)) {
                $errors[$key] = 'Заполните это поле';
                continue;
            }

            if (in_array($key, ['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[$key] = 'Не корректный ввод email!';
            }

            if (searchUserByEmail($_POST['email'], $users)) {
                $errors['email'] = "Такой пользователь уже зарегистрирован!";
            }
        }
        //$errors = checkEmptyPost($_POST);

        if (isset($_FILES['user_avatar'])) {
            $user_avatar = $_FILES['user_avatar'];
            if ($user_avatar) {
                if ($user_avatar['type'] == 'image/jpeg') {
                    move_uploaded_file($user_avatar['tmp_name'], '/img/' . $user_avatar['name']);
                } else {
                    $errors['user_avatar'] = 'Неверный формат!';
                }
            } else {
                $user_avatar = ['name' => 'avatar.jpg'];
            }

        }

        if (empty($errors)) {
            $users_email = $_POST['email'];
            $user_name = $_POST['name'];
            $users_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $avatar_path = '/img/' . $user_avatar['name'];
            $user_contacts = $_POST['message'];

            $data = [$users_email, $user_name, $users_password, $avatar_path, $user_contacts];

            $sql = "INSERT INTO users (`registration_date`, `email`, `name`, `password`, `avatar_path`, `contacts`)"
                ."VALUE (NOW(), ?, ?, ?, ?, ?)";

            $user = insertData($link, $sql, $data);

            $_SESSION['user'] = $user;

            header("Location: /");
            exit();

        }
    }
}

//print_r($_POST['email']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<?= includeTemplate('header.php'); ?>

<?= includeTemplate('sign_up.php', ['categories' => $categories, 'errors' => $errors, 'user_avatar' => $user_avatar]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>

