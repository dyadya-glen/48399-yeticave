CREATE DATABASE YetiCave;

USE YetiCave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128),
  css_class CHAR(64)
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_date DATETIME,
  completion_date DATETIME,
  name CHAR(128),
  description TEXT,
  image CHAR(255),
  initial_price INT,
  step_bet INT,
  additions_favorites INT,
  user_id INT,
  winner_id INT,
  category_id INT
);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_date DATETIME,
  amount INT,
  user_id INT,
  lot_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date DATETIME,
  email CHAR(255),
  name CHAR(255),
  password CHAR(64),
  avatar_path CHAR(255),
  contacts TEXT
);

CREATE INDEX name ON lots(name);

CREATE UNIQUE INDEX email ON users(email);