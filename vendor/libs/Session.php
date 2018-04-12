<?php

namespace vendor\libs;

class Session
{
    /**
     * Должны быть методы:
     * 1. Добавить чтото в сесию
     */
//    public static $key;
//    public static $values;

    /**
     * Сохраняет данные по ключю
     * @param $key
     * @param $values
     * @return mixed
     */
    public static function create($key, $values)
    {
        return $_SESSION[$key] = $values;
    }

    /**
     * Получает данные по ключю
     */
    public static function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Существует ли значение с таим ключем
     * @param $key
     * @return bool
     */
    public static function isSession($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Удаляет по ключю
     */
    public static function remove($key = [])
    {
        unset($_SESSION[$key]);
    }

    /**
     * Обновись значение по ключю
     */
    public static function update($key, $values) {
        return $_SESSION[$key] = $values;
    }
}