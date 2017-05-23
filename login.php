<?php

require_once 'bootstrap.php';

$form = new LogInForm();

if ($form->isSubmitted()) {
    $form->validate();
    if ($form->isValid()) {
        $user = searchUserByEmail($data_base, $form->getFieldData('email'));

        if ($user) {
            if ($auth_user->authenticateUser($user, $form->getFieldData('password'))) {
                header("Location: /");
                exit();
            } else {
                $form->setError('password', 'Не верный пароль!');
            }
        } else {
            $form->setError('email', "Пользователь не найден!");
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

<?= includeTemplate(
    'header.php',
    [
        'is_authorized' => $auth_user->isAuthorized(),
        'user' => $auth_user->getDataUser()
    ]
); ?>

<?= includeTemplate('login.php', ['categories' => $categories, 'form' => $form]); ?>

<?= includeTemplate('footer.php', ['categories' => $categories]); ?>

</body>
</html>