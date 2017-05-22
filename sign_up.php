<?php

require_once 'bootstrap.php';

$errors = [];
$user_avatar = [];

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = strip_tags($value);

        if (empty($value)) {
            $errors[$key] = 'Заполните это поле';
            continue;
        }

        if (in_array($key, ['email']) && !filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)) {
            $errors[$key] = 'Не корректный ввод email!';
        }

        if (in_array($key, ['email']) && searchUserByEmail($data_base, $_POST[$key])) {
            $errors[$key] = "Такой пользователь уже зарегистрирован!";
        }
    }

    if (isset($_FILES['user_avatar']) && $_FILES['user_avatar']['error'] == UPLOAD_ERR_OK) {
        $user_avatar = $_FILES['user_avatar'];
        if ($user_avatar['type'] == 'image/jpeg') {
            move_uploaded_file(
                $user_avatar['tmp_name'],
                $_SERVER['DOCUMENT_ROOT'] . '/img/' . $user_avatar['name']
            );
        } else {
            $errors['user_avatar'] = 'Неверный формат!';
        }
    } else {
        $user_avatar['name'] = 'i.jpg';
    }

    if (empty($errors)) {
        $user = [
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'avatar_path' => '/img/' . $user_avatar['name'],
            'contacts' => $_POST['message']
        ];

        $data = [$user['email'], $user['name'], $user['password'], $user['avatar_path'], $user['contacts']];

        $sql = "INSERT INTO users (`registration_date`, `email`, `name`, `password`, `avatar_path`, `contacts`)"
            ."VALUE (NOW(), ?, ?, ?, ?, ?)";

        $user_id = $data_base->insertData($sql, $data);

        if (!empty($user_id)) {
            $user['id'] =  $user_id;

            $_SESSION['user'] = $user;

            header("Location: /");

            exit();
        }

    }
}

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

<?= includeTemplate(
    'header.php',
    [
        'is_authorized' => $auth_user->isAuthorized(),
        'user' => $auth_user->getDataUser()
    ]
); ?>

<?= includeTemplate('sign_up.php', ['categories' => $categories, 'errors' => $errors]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>

