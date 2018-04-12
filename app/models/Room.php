<?php

namespace app\models;

use vendor\core\Db;

class Room extends House
{
    public function __construct($max)
    {
        $pdo = Db::instance();
//        $room = $pdo->pdo->prepare("INSERT INTO `room` (`number_max`) VALUES (?)", [$max]);
//        $room->execute();
        $room = $pdo->pdo->prepare("INSERT INTO `room` (`number_max`) VALUES (:max)");
        $room->bindParam(':max', $max);
        $room->execute();
        
        $room = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
        $this->id = $room['id'];
        $this->number_now = $room['number_now'];
    }
}
