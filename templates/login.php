<?php
/**
 * @var LogInForm $from
 */
?>
<main>

    <?php require_once 'menu_categories.php' ?>

    <form class="form container <?= !$form->isValid() ? ' form--invalid' : '' ?>" action="login.php" method="post">
        <h2>Вход</h2>
        <div class="form__item<?= !$form->isValidField('email') ? ' form__item--invalid' : '' ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="login[email]" value="<?= $form->getFieldData('email') ?>" placeholder="Введите e-mail">
            <span class="form__error"><?= $form->getError('email') ?></span>
        </div>
        <div class="form__item form__item--last<?= !$form->isValidField('password') ? ' form__item--invalid' : '' ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="login[password]" placeholder="Введите пароль">
            <span class="form__error"><?= $form->getError('password') ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
