# 1.получить список из всех категорий;
SELECT * FROM categories;

# 2.получить самые новые, открытые лоты.
# Каждый лот должен включать название, стартовую цену,
# ссылку на изображение, цену, количество ставок, название категории;
SELECT lots.`name`, `initial_price`, `image`, `categories`.`name` AS 'category', COUNT(DISTINCT bets.id) AS bets, MAX(bets.`amount`) AS price
FROM lots
JOIN `categories`
ON lots.`category_id` = `categories`.id
LEFT JOIN bets
ON lots.id = bets.`lot_id`
WHERE `completion_date` > NOW()
GROUP BY lots.id
ORDER BY lots.created_date DESC;

# 3.найти лот по его названию или описанию;
SELECT * FROM lots
WHERE  name LIKE "%Маска%"
OR description LIKE "%день%";

# 4.добавить новый лот (все данные из формы добавления);
INSERT INTO lots (`name`,
                  `category_id`,
                  `description`,
                  `image`,
                  `initial_price`,
                  `step_bet`,
                  `created_date`,
                  `completion_date`,
                  `user_id`)
VALUE ("Super-Board 2017",
       "1",
       "Эта доска доставит вас к подножью горы в мгновение ока!!!",
       "img/lot-7.jpg",
       "10789",
       "200",
       NOW(),
       "2017-06-07 13:15:00",
       "1");

# 5.обновить название лота по его идентификатору;
UPDATE lots SET `name` = 'Arbor Draft (16-17)' WHERE `id` = '7';

# 6.добавить новую ставку для лота;
INSERT INTO `bets` (`created_date`,
                    `amount`,
                    `user_id`,
                    `lot_id`)
VALUE (NOW(),
       "10989",
       "3",
       "7");

# 7.получить список ставок для лота по его идентификатору.
SELECT * FROM bets WHERE `lot_id` = 6;

# 8. Добавление столбща в таблицу
ALTER TABLE categories ADD COLUMN css_class CHAR(64) AFTER name;