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
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($my_bets as $my_bet) : ?>
                <tr class="rates__item">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= strip_tags($my_bet['lot_image'])?>" width="54" height="40" alt="Сноуборд">
                        </div>
                        <h3 class="rates__title">
                            <a href="lot.php?id=<?= $my_bet['lot_id'] ?>">
                                <?= strip_tags($my_bet['lot_name'])?>
                            </a>
                        </h3>
                    </td>
                    <td class="rates__category">
                        <?= strip_tags($my_bet['category'])?>
                    </td>
                    <td class="rates__timer">
                        <div class="timer timer--finishing">07:13:34</div>
                    </td>
                    <td class="rates__price">
                        <?= strip_tags($my_bet['amount'])?>
                    </td>
                    <td class="rates__time">
                        <?= formatTime(strtotime($my_bet['created_date']))?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>