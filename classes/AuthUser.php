<?php

/**
 * Created by PhpStorm.
 * AuthUser: glen
 * Date: 16.05.17
 * Time: 14:31
 */
class AuthUser
{
    /** @var string $session_key ключ сессии */
    private $session_key = 'user';

    /**
     * Метод авторизовывает пользователя,
     * возвращает true в случае успеха и
     * false в противном случае.
     *
     * @param $user
     * @param $password
     * @return bool
     */
    public function authenticatedUser($user, $password)
    {
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION[$this->session_key] = $user;
        return true;
    }

    /**
     * Метод проверяет
     * аутентифицированность
     * текущего пользователя.
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return isset($_SESSION[$this->session_key]);
    }

    /**
     *Метод разлогинивает пользователя.
     */
    public function logout()
    {
        if ($this->isAuthorized()) {
            unset($_SESSION[$this->session_key]);
        }
    }

    /**
     * Метод возвращает информацию
     * о текущем залогиненном пользователе.
     * либо null при отсутствии залогиненного
     * пользователя.
     *
     * @return null
     */
    public function getDataUser()
    {
        if ($this->isAuthorized()) {
            return $_SESSION[$this->session_key];
        }
        return null;
    }
}
