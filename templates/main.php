<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $category) : ?>
                <li class="promo__item <?= $category['css_class']; ?>">
                    <a class="promo__link" href="#"><?= $category['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
            <select class="lots__select">
                <option>Все категории</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <ul class="lots__list">
            <?php foreach ($bulletin_board as $bulletin) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= strip_tags($bulletin["image"]); ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= strip_tags($bulletin["category"]); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $bulletin["id"] ?>"><?= strip_tags($bulletin["lot_name"]); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= strip_tags($bulletin["initial_price"]); ?><b class="rub">р</b></span>
                            </div>
                            <div class="lot__timer timer">
                                <?= lot_time_remaining(strtotime($bulletin['completion_date'])); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>