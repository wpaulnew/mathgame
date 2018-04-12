<?php

namespace app\models;

use function Sodium\add;
use vendor\core\Db;

class Players
{
    public function getId($login, $password) {
        $pdo = Db::instance();
        return $pdo->getRow("SELECT `id` FROM `u` WHERE `login` = '{$login}' AND `password` = '{$password}'");
    }

    public function update($id) {
        $pdo = Db::instance();
        $pdo->updateRow("UPDATE `players` SET `current_room` = '0' WHERE `id` = '{$id}'");
    }
}