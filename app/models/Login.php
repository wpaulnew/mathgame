<?php

namespace app\models;

use function Sodium\add;
use vendor\core\Db;

class Login
{
    public function addU($login, $password)
    {
        $pdo = Db::instance();
        /**
         * Вводит логин и пароль
         * Если в базе есть пользователь с таким логином то ошибка
         * А если такой логин есть и пароль подходит тогда мы авторизуем
         */
        $count = $this->findProfile($login, $password);
        if ($count) {
            // Сравниваем введеные данные
            // Проверяем если пароль подходит к логину
            return true;
        } else {
            $query = $pdo->pdo->query("SELECT `id` FROM `players` WHERE `login` = '{$login}'");
            $count = $query->rowCount();

            if ($count) {
                return false;
            } else {
                $photo = "i.png";

                $stmt = $pdo->pdo->prepare("INSERT INTO `players` (login, password, photo) VALUES (:login, :password, :photo)");
                $stmt->bindParam(':login', $login);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':photo', $photo);
                $stmt->execute();
                return true;
            }
        }

    }

    public function getUId($login, $password)
    {
        $pdo = Db::instance();
        return $pdo->getRow("SELECT `id` FROM `players` WHERE `login` = '{$login}' AND `password` = '{$password}'");
    }

    public function findProfile($login, $password)
    {
        $pdo = Db::instance();
        $query = $pdo->pdo->query("SELECT * FROM `players` WHERE `login` = '{$login}' AND `password` = '{$password}'");
        return $query->rowCount();
    }

}