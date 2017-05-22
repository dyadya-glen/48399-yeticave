<?php

/**
 * Created by PhpStorm.
 * AuthUser: glen
 * Date: 16.05.17
 * Time: 13:30
 */
class DataBase
{
    private $link;

    /**
     * Конструктор который при
     * вызове объекта устанавливает
     * соединение с базой данных.
     *
     * DataBase constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $database
     *

     */
    public function __construct($host, $user, $password, $database)
    {
        $this->link = mysqli_connect($host, $user, $password, $database);
    }

    /**
     * Метод определяет соединение с базой данных.
     *
     * @return bool
     */
    public function connected()
    {
        return !mysqli_connect_errno();
    }

    /**
     * Метод возвращает информацию о последней ошибке.
     *
     * @return string
     */
    public function getLastError()
    {
        if ($this->connected()) {
            $error = mysqli_error($this->link);
        } else {
            $error = mysqli_connect_error();
        }
        return $error;
    }

    /**
     *  Метод выполняет запросы и возвращать их результат.
     *
     * @param $sql
     * @param array $data
     * @return array
     */
    public function receivingData($sql, $data = [])
    {
        $stmt = db_get_prepare_stmt($this->link, $sql, $data);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $rows = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Метод выполняет запросы и добавляет данные.
     *
     * @param $sql
     * @param $data
     * @return bool|int|string
     */
    public function insertData($sql, $data)
    {
        $stmt = db_get_prepare_stmt($this->link, $sql, $data);
        mysqli_stmt_execute($stmt);
        $last_entry = mysqli_insert_id($this->link);

        if ($last_entry < 1) {
            return false;
        }

        return $last_entry;
    }

    /**
     * Метод выполняет запросы и обновляет данные.
     *
     * @param $table_name
     * @param array $update_data
     * @param array $where
     * @return bool|int|string
     */
    public function updateData($table_name, array $update_data, array $where)
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

        $stmt = db_get_prepare_stmt($this->link, $sql, $data);
        mysqli_stmt_execute($stmt);
        $rows_count = mysqli_stmt_affected_rows($stmt);

        if ($rows_count < 0) {
            return false;
        }

        return $rows_count;
    }
}