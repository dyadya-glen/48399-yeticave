<main>

<?php require_once 'menu_categories.php' ?>

    <form class="form form--add-lot container<?= !empty($errors) ? ' form--invalid' : '' ?>" action="add.php" method="post" enctype="multipart/form-data">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item<?= !empty($errors['lot-name']) ? ' form__item--invalid' : '' ?>">
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" value="<?= isset($_POST['lot-name']) ? $_POST['lot-name'] : '' ?>" placeholder="Введите наименование лота">
                <span class="form__error"><?= !empty($errors['lot-name']) ? $errors['lot-name'] : '' ?></span>
            </div>
            <div class="form__item<?= !empty($errors['category']) ? ' form__item--invalid' : '' ?>">
                <label for="category">Категория</label>
                <select id="category" name="category">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>" <?= isset($_POST['category']) && $category['id'] == $_POST['category'] ? 'selected' : ''; ?> ><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?= !empty($errors['category']) ? $errors['category'] : '' ?></span>
            </div>
        </div>

        <div class="form__item form__item--wide<?= !empty($errors['message']) ? ' form__item--invalid' : '' ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота"><?= isset($_POST['message']) ? $_POST['message'] : '' ?></textarea>
            <span class="form__error"><?= !empty($errors['message']) ? $errors['message'] : '' ?></span>
        </div>

        <div class="form__item form__item--file<?= empty($errors['uploadfile']) && !empty($photoLot['tmp_name']) ? ' form__item--uploaded' : '' ?>">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?= empty($errors['uploadfile']) && !empty($photoLot['tmp_name']) ? '../img/' . $photoLot['name'] : '' ?>" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="uploadfile">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small<?= !empty($errors['lot-rate']) ? ' form__item--invalid' : '' ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" value="<?= isset($_POST['lot-rate']) ? $_POST['lot-rate'] : '' ?>" placeholder="0">
                <span class="form__error"><?= !empty($errors['lot-rate']) ? $errors['lot-rate'] : '' ?></span>
            </div>
            <div class="form__item form__item--small<?= !empty($errors['lot-step']) ? ' form__item--invalid' : '' ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" value="<?= isset($_POST['lot-step']) ? $_POST['lot-step'] : '' ?>" placeholder="0">
                <span class="form__error"><?= !empty($errors['lot-step']) ? $errors['lot-step'] : '' ?></span>
            </div>
            <div class="form__item<?= !empty($errors['completion_date']) ? ' form__item--invalid' : '' ?>">
                <label for="completion_date">Дата завершения</label>
                <input class="form__input-date" id="completion_date" type="text" name="completion_date" value="<?= isset($_POST['completion_date']) ? $_POST['completion_date'] : '' ?>" placeholder="20.05.2017">
                <span class="form__error"><?= !empty($errors['completion_date']) ? $errors['completion_date'] : '' ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>