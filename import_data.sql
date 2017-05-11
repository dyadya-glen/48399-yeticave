INSERT INTO `categories` (`name`, `css_class`)
  VALUE ('Доски и лыжи', 'promo__item--boards'),
  ('Крепления', 'promo__item--attachment'),
  ('Ботинки', 'promo__item--boots'),
  ('Одежда', 'promo__item--clothing'),
  ('Инструменты', 'promo__item--tools'),
  ('Разное', 'promo__item--other');

INSERT INTO `users` (`registration_date`, `email`, `name`, `password`, `avatar_path`, `contacts`)
  VALUE (NOW(),
         'ignat.v@gmail.com',
         'Игнат',
         '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka',
         '/img/user.jpg',
         'Самара, Сроителей 8'
),
  (NOW(),
   'kitty_93@li.ru',
   'Леночка',
   '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa',
   '/img/Lenochka.jpg',
   'Ленинградское шоссе, 25й километр у шашлычной'
  ),
  (NOW(),
   'warrior07@mail.ru',
   'Руслан',
   '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
   '/img/Ruslan.jpg',
   'Улан-удэ, Ленина 10');

INSERT INTO `lots` (`created_date`,
                    `completion_date`,
                    `name`,
                    `description`,
                    `image`,
                    `initial_price`,
                    `step_bet`,
                    `additions_favorites`,
                    `user_id`,
                    `winner_id`,
                    `category_id`)
  VALUE (NOW(),
  '2017-06-11 09:05:00',
  '2014 Rossignol District Snowboard',
  'В тот день ему опять повезло. В пахучем кусте можжевельника, с которого он обрывал губами сизые, матовые ягоды, увидел он какой-то странный комок палого листа. Он тронул рукой - комок был тяжелый и не рассыпался. Тогда он стал обрывать листья и накололся на торчавшие сквозь них иглы. Он догадался: ёжик.',
  '/img/lot-1.jpg',
  10000,
  500,
  1,
  1,
  NULL,
  1
),
  (NOW(),
    '2017-06-08 09:05:00',
    'DC Ply Mens 2016/2017 Snowboard',
    'Большой старый ёж, забираясь в чащу куста на зимовку, для тепла накатал на себя палых осенних листьев. Безумная радость овладела Алексеем. Весь свой скорбный путь мечтал он убить зверя или птицу.',
    '/img/lot-2.jpg',
    59999,
    100,
    2,
    1,
    NULL,
    1
  ),
  (NOW(),
    '2017-06-05 09:05:00',
    'Крепления Union Contact Pro 2015 года размер L/XL',
    'Сколько раз вынимал он пистолет и прицеливался то в сороку, то в сойку, то в зайца и всякий раз с трудом превозмогал желание выстрелить. В пистолете оставалось только три патрона: два для врага, один, в случае надобности, для себя. Он заставлял себя убирать пистолет. Он не имел права рисковать.',
    '/img/lot-3.jpg',
    8000,
    200,
    4,
    3,
    NULL,
    2
  ),
  (NOW(),
    '2017-06-04 18:05:00',
    'Ботинки для сноуборда DC Mutiny Charocal',
    'А тут кусок мяса сам попал к нему в руки. Ни минуты не задумываясь, над тем, что ежи считаются, по поверью, животными погаными, он быстро сорвал со зверька чешую листвы. Ёж не просыпался, не развертывался и походил на смешной, ощетинившийся иглами огромный боб.',
    '/img/lot-4.jpg',
    10999,
    300,
    7,
    4,
    NULL,
    3
  ),
  (NOW(),
    '2017-06-04 11:05:00',
    'Куртка для сноуборда DC Mutiny Charocal',
    'Ударом кинжала Алексей убил ежа, развернул его, неумело содрал желтую шкурку на брюшке и иглистый панцирь, рассек на части и с наслаждением стал рвать зубами еще теплое, сизое, жилистое мясо, плотно приросшее к костям. Ёж был съеден сразу, без остатка.',
    '/img/lot-5.jpg',
    7500,
    400,
    5,
    2,
    NULL,
    4
  ),
  (NOW(),
    '2017-06-02 10:25:00',
    'Маска Oakley Canopy',
    'Алексей разгрыз и проглотил все мелкие кости и только после этого ощутил во рту противный запах псины. Но что значит этот запах по сравнению с полным желудком, от которого по всему организму разливались сытость, теплота и дрема!',
    '/img/lot-6.jpg',
    5400,
    70,
    10,
    4,
    NULL,
    6);

INSERT INTO `bets` (`created_date`, `amount`, `user_id`, `lot_id`)
VALUES ('2017-05-03 12:05:00',10500,3,1),
  ('2017-05-05 10:07:00',11000,2,1),
  ('2017-05-06 10:05:00',11500,3,1),
  ('2017-05-07 12:05:00',12000,2,1);
