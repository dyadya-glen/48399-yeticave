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
  <form class="form container <?= !empty($errors) ? ' form--invalid' : '' ?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item<?= !empty($errors['email']) ? ' form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="Введите e-mail">
      <span class="form__error"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="form__item form__item--last<?= !empty($errors['password']) ? ' form__item--invalid' : '' ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль">
      <span class="form__error"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Войти</button>
  </form>
</main>
