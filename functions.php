<?php

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

function decodesСookie()
{
    $my_bets = [];

    if (isset($_COOKIE["my_bets"])) {
        $my_bets = json_decode($_COOKIE["my_bets"], true);
    }

    return $my_bets;
}