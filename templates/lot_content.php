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
    <section class="lot-item container">
        <h2><?= strip_tags($lot['lot_name']) ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= strip_tags($lot['image'])?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?= strip_tags($lot['category'])?></span></p>
                <p class="lot-item__description"><?= strip_tags($lot['description']) ?></p>
            </div>
            <div class="lot-item__right">
                <?php if (isset($_SESSION['user'])) : ?>
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer">
                            <?= lot_time_remaining(strtotime($lot['completion_date'])); ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= strip_tags($price) ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= $price + $lot['step'] ?></span>
                            </div>
                        </div>
                        <?php if (empty($is_lot_has_bet)) : ?>
                            <form class="lot-item__form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                <p class="lot-item__form-item">
                                    <label for="cost">Ваша ставка</label>
                                    <input id="cost" type="text" name="cost" placeholder="<?= $price + $lot['step'] ?>">
                                </p>
                                <button type="submit" class="button">Сделать ставку</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif;?>
                <div class="history">
                    <h3>История ставок (<span><?= count($bets); ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bets as $cell) : ?>
                            <tr class="history__item">
                                <td class="history__name"><?= strip_tags($cell["name"]); ?></td>
                                <td class="history__price"><?= strip_tags($cell["amount"]); ?></td>
                                <td class="history__time"><?= formatTime(strtotime($cell["created_date"])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>