<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="#"><?= $category['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? ' form--invalid' : '' ?>" action="sign_up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item<?= !empty($errors['email']) ? ' form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Введите e-mail">
            <span class="form__error"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
        </div>
        <div class="form__item<?= !empty($errors['password']) ? ' form__item--invalid' : '' ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
        </div>
        <div class="form__item<?= !empty($errors['name']) ? ' form__item--invalid' : '' ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" placeholder="Введите имя">
            <span class="form__error"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
        </div>
        <div class="form__item<?= !empty($errors['message']) ? ' form__item--invalid' : '' ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= isset($_POST['message']) ? $_POST['message'] : '' ?></textarea>
            <span class="form__error"><?= isset($errors['message']) ? $errors['message'] : '' ?></span>
        </div>
        <div class="form__item form__item--file form__item--last<?= !empty($errors['user_avatar']) ? ' form__item--invalid' : '' ?>">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="/img/avatar.jpg" width="113" height="113" alt="Изображение">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="user_avatar" value="<?= isset($_FILES['user_avatar']) ? $_FILES['user_avatar'] : '' ?>">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
                <span class="form__error"><?= isset($errors['user_avatar']) ? $errors['user_avatar'] : '' ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>