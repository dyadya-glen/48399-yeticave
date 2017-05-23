<?php
session_start();

require 'functions.php';

require_once 'classes/DataBase.php';
require_once 'classes/AuthUser.php';
require_once 'classes/BaseForm.php';
require_once 'classes/LogInForm.php';


$data_base = new DataBase('localhost', 'root', 'root', 'Yeticave');
$auth_user = new AuthUser();


if (!$data_base->connected()) {
    header('HTTP/1.1 500 Internal Server Error');
    print('Ошибка подключения: ' . $data_base->getLastError());
    die();

}

$sql = "SELECT * FROM categories";
$categories = $data_base->receivingData($sql);
