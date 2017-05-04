<main>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="all-lots.html">Доски и лыжи</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Крепления</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Ботинки</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Одежда</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Инструменты</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Разное</a>
            </li>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($my_bets as $my_bet) : ?>
                <?php
                $lot_id = $my_bet['lot_id'];
                $lot_element = $bulletin_board[$lot_id];
                ?>
                <tr class="rates__item">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= strip_tags($lot_element['url_image'])?>" width="54" height="40" alt="Сноуборд">
                        </div>
                        <h3 class="rates__title">
                            <a href="lot.php?id=<?= $lot_id ?>">
                                <?= strip_tags($lot_element['name'])?>
                            </a>
                        </h3>
                    </td>
                    <td class="rates__category">
                        <?= strip_tags($lot_element['category'])?>
                    </td>
                    <td class="rates__timer">
                        <div class="timer timer--finishing">07:13:34</div>
                    </td>
                    <td class="rates__price">
                        <?= strip_tags($my_bet['cost'])?>
                    </td>
                    <td class="rates__time">
                        <?= formatTime($my_bet['time'])?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>