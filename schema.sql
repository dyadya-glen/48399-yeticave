CREATE DATABASE YetiCave;

USE YetiCave;

CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR(128)
);

CREATE TABLE lot (
id INT AUTO_INCREMENT PRIMARY KEY,
created_date DATETIME,
completion_date DATETIME,
name CHAR(128),
description TEXT,
image CHAR(255),
initial_price INT,
step_bet INT,
additions_favorites INT,
author_id INT,
winner_id INT,
category_id INT
);

CREATE TABLE bet (
id INT AUTO_INCREMENT PRIMARY KEY,
date_bet DATETIME,
amount_bet INT,
user_id INT,
lot_id INT
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
registration_date DATETIME,
email CHAR(255),
user_name CHAR(255),
password CHAR(64),
avatar_path CHAR(255),
contacts TEXT,
user_lots_id INT,
user_bets_id INT
);

CREATE INDEX name ON categories(name);

CREATE UNIQUE INDEX name ON lot(name);

CREATE UNIQUE INDEX amount ON bet(amount_bet);

CREATE UNIQUE INDEX email ON users(email);

CREATE UNIQUE INDEX name ON users(user_name);