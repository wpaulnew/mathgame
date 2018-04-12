<?php

namespace app\models;

use vendor\core\Db;

/**
 * В доме мы проверяем есть ли пустые комнаты или нет
 */
class House
{
    protected $id;
    protected $number_now;
    protected $number_max = 3;
    protected $room_condition = true;
    protected $winner_id;

    public function issetRoom($max)
    {
        $pdo = Db::instance();
//        $room = $pdo->getRow("SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`) AND
//        `room_condition` = 0 AND `number_max` != `number_now`");

        $room = $pdo->getRow("SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`) AND `room_condition` = 0 AND `number_max` != `number_now` AND `number_max` = '{$max}'");


        // Проверяем комнату на существование
        if ($room) {
            // Если комната существует то мы проверяем ее статус
            if ($room['room_condition'] == 1) {
                // Если она пуста возвращаем true
//                $this->id = $room['id'];
//                $this->number_now = $room['number_now'];
                return false;
            } else {
                // Если не пуста возвращаем false
                return true;
            }
        } else {
            // Если комната не существует возвращаем false
            return false;
        }
    }


    public function getRoomKey()
    {
        return $this->id;
    }

    public function getRoomNumberNow()
    {
        return $this->number_now;
    }

    public function getRoomNumberMax()
    {
        return $this->number_max;
    }

    public function getRoomCondition()
    {
        return $this->room_condition;
    }

    public function setRoomKey($id)
    {
        return $this->id = $id;
    }

    public function setRoomNumberNow($number)
    {
        return $this->number_now = $number;
    }

    public function setRoomNumberMax($number)
    {
        return $this->number_max = $number;
    }

    public function setRoomCondition($condition)
    {
        return $this->room_condition = $condition;
    }

    public function addPlayerToRoom($id)
    {
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `players` SET `current_room` = ? WHERE `id` = ?', [$this->id, $id]);
    }

    public function getRoomFromEnd()
    {
        $pdo = Db::instance();
        return $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
    }

    public function countPlayersInRoom()
    {
        $pdo = Db::instance();
        $pdo = $pdo->pdo->query("SELECT `id` FROM `players` WHERE `current_room` = '{$this->id}'");
        return $this->number_now = $pdo->rowCount();
    }

    public function updateNumberNow()
    {
        $pdo = Db::instance();
//        $pdo = $pdo->pdo->query("SELECT `id` FROM `u` WHERE `current_room` = '{$this->id}'");
//        $number = $pdo->rowCount();
//        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `room` SET `number_now` = ? WHERE `id` = ?', [$this->number_now, $this->id]);
    }

    public function updateCondition()
    {
        $pdo = Db::instance();
        $condition = $pdo->getRow("SELECT `number_max`,`number_now` FROM `room` WHERE `id` = '{$this->id}'");
//        print_r($condition);
        if ($condition['number_max'] == $condition['number_now']) {
            $pdo->updateRow('UPDATE `room` SET `room_condition` = ? WHERE `id` = ?', ['1', $this->id]);
            return false;
        }
        return true;
    }

    public function numberConflict()
    {
        $pdo = Db::instance();
        $number = $pdo->getRow("SELECT `number_max`,`number_now` FROM `room` WHERE `id` = '{$this->id}'");
        if ($number['number_max'] == $number['number_now']) {
            return false;
        }
        return true;
//        return $number;
    }

    /**
     * Показывает фото игроков.
     * Передаем id комнаты
     */
    public function getPhotos()
    {
        $pdo = Db::instance();
        return $pdo->getRows("SELECT `id`,`photo` FROM `players` WHERE current_room = '{$this->id}'");
//         return $pdo->pdo->query("SELECT photo FROM `players` WHERE current_room = '{$this->id}'", \PDO::FETCH_SERIALIZE);

//        $pdo->pdo->query("SELECT photo FROM `players` WHERE current_room = '{$this->id}'");
    }

    public function getWinner($id) {
        $pdo = Db::instance();
        $winner = $pdo->getRow("SELECT `winner` FROM `room` WHERE `id` = '{$id}'");
        return $pdo->getRow("SELECT `id`,`login`,`photo` FROM `players` WHERE `id` = '{$winner['winner']}'");
    }
}