<?php

namespace vendor\libs;

use vendor\core\Db;

class Profile
{
    public $id;
    public $login;
    public $password;

    public function add($login, $password)
    {
        $pdo = Db::instance();

//        $count = $this->find($login, $password);
//        if ($count) {
//            // Сравниваем введеные данные
//            // Проверяем если пароль подходит к логину
//            return print 'true';
//        } else {
//            // проверяем есть ли человек в базе
//            $count = $pdo->findRow("SELECT `id` FROM `profiles` WHERE `login` = ?", [$login]);
//
//            if (!$count) {
//                $this->registerProfile($login, $password);
//            }
//            return print 'false';
//        }

    }

    public function find()
    {
        $pdo = Db::instance();
        $query = $pdo->pdo->query("SELECT * FROM `profiles` WHERE `login` = '{$this->login}' AND `password` = '{$password}'");
        return $query->rowCount();
    }

    public function register()
    {
        $pdo = Db::instance();
//        $stmt = $pdo->pdo->prepare("INSERT INTO `profiles` (login, password) VALUES (:login, :password)");
//        $stmt->bindParam(':login', $login);
//        $stmt->bindParam(':password', $password);
//        $stmt->execute();
        $pdo->insertRow("INSERT INTO `profiles` (login, password) VALUES (?, ?)", [$this->login, $this->password]);
        return true;
    }

    /**
     * Проверяе тесть ли такой пользлватель в базе
     * @return int
     */
    public function findLogin() {
        $pdo = Db::instance();
        $query = $pdo->pdo->query("SELECT * FROM 'profiles' WHERE `login` = 'Paul'");
        return $query->rowCount();
    }
}