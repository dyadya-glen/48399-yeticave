<?php

include 'mysql_helper.php';

function includeTemplate($template, $array_data = [])
{
    $template = 'templates/' . $template;

    if (!file_exists($template) || !is_file($template)) {
        return "";
    }

    extract($array_data);

    ob_start();

    include_once($template);

    $html_template = ob_get_clean();

    return $html_template;
}

function lot_time_remaining()
{
    date_default_timezone_set('Europe/Moscow');

    $tomorrow = strtotime('tomorrow midnight');

    $now = time();

    $remaining_time_seconds = $tomorrow - $now;

    $remaining_time_hours = floor($remaining_time_seconds / 3600);

    if ($remaining_time_hours < 10) {
        $remaining_time_hours = "0" . $remaining_time_hours;
    }

    $remaining_time_minutes = floor(($remaining_time_seconds % 3600) / 60);

    if ($remaining_time_minutes < 10) {
        $remaining_time_minutes = "0" . $remaining_time_minutes;
    }

    $lot_time_remaining = $remaining_time_hours . ":" . $remaining_time_minutes;

    return $lot_time_remaining;
}

function formatTime($markerTime)
{
    date_default_timezone_set('Europe/Moscow');

    $diff_time = time() - $markerTime;
    $elapsed_time = $diff_time / 3600;

    if ($elapsed_time >= 24) {
        $result = date("d.m.y в H:i", $markerTime);
    } elseif ($elapsed_time < 24 && $elapsed_time >= 1) {
        $result = date("G часов назад", $diff_time);
    } else {
        $result = ltrim(date("i минут назад", $diff_time), "0");
    }

    return $result;
}

function checkEmptyPost($post)
{
    $errors = [];

    foreach ($post as $key => $value) {
        $post[$key] = strip_tags($value);

        if (empty($value)) {
            $errors[$key] = 'Заполните это поле';
            continue;
        }
    }

    return $errors;
}

function searchUserByEmail($email, $users)
{
    $result = null;

    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;

            break;
        }
    }

    return $result;
}


function isLotHasBet($lot_id, $my_bets)
{
    foreach ($my_bets as $bet) {
        if ($bet['lot_id'] == $lot_id) {
            return true;
        }
    }

    return false;
}

function getBetsList()
{
    $my_bets = [];

    if (isset($_COOKIE["my_bets"])) {
        $my_bets = json_decode($_COOKIE["my_bets"], true);
    }

    return $my_bets;
}

function getDbConnection()
{
    $con = mysqli_connect("localhost", "root", "root", "YetiCave");
    return $con;
}

function receivingData($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $rows[] = $row;
    }

    return $rows;
}

function insertData($link, $sql, $data)
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $last_entry = mysqli_insert_id($link);

    if ($last_entry < 1) {
        return false;
    }

    return $last_entry;
}

function updateData($link, $table_name, array $update_data, array $where)
{
    $sql = "UPDATE `$table_name` SET ";
    $data = [];
    $array_update = [];
    foreach ($update_data as $column => $value) {
        $array_update[] = "`$column` = ?";
        $data[] = $value;
    }
    $sql .= implode(', ', $array_update);
    $sql .= " WHERE ";
    $array_where = [];
    foreach ($where as $column => $value) {
        $array_where[] = "`$column` = ?";
        $data[] = $value;
    }
    $sql .= implode(' AND ', $array_where);
    $sql .= ";";

    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $rows_count = mysqli_stmt_affected_rows($stmt);

    if ($rows_count < 0) {
        return false;
    }

    return $rows_count;
}
