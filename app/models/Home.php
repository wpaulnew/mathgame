<?php

namespace app\models;

use vendor\core\Db;

class Home extends House
{
    public function getPlayerInfo($id) {
        $pdo = Db::instance();
        return $pdo->getRow("SELECT `login`,`photo`,`win` FROM `players` WHERE `id` = '{$id}'");
    }
}
