<?php

//namespace app\models;

use vendor\core\Db;

class RoomNew
{
    public $id;
    public $number_max;
    public $number_now;
    public $room_condition = true;
    public $winner_id;

    public function __construct()
    {
//        $pdo = Db::instance();
//        $room = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
//        if (!$room) {
//            $room = $pdo->pdo->prepare("INSERT INTO `room` () VALUES ()");
//            $room->execute();
//            $room = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
//        }
//        $this->id = $room['id'];
//        $this->number_max = $room['number_max'];
//        $this->number_now = $room['number_now'];

    }

    /**
     * Для добавления пользователя в комнату по id пользователя
     */
    public function addToRoom($id)
    {
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `u` SET `current_room` = ? WHERE `id` = ?', [$this->id, $id]);
    }

    /**
     * Получаем id текущей комнаты по id пользователя
     */
    public function getRoomAddress($id)
    {
        $pdo = Db::instance();
        $stmt = $pdo->pdo->query("SELECT `current_room` FROM `u` WHERE `id` = '{$id}'");
        return $stmt->rowCount();
    }

    /**
     * Удаляем из комнаты по id пользователя
     */
    public function removeFromRoom($id)
    {
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `u` SET `current_room` = ? WHERE `id` = ?', [0, $id]);
    }

    /**
     * Выводим количество игроков в комнате по id комнаты
     */
    public function getNumberNow()
    {
        return $this->number_now;
    }

    /**
     * Получаем вывод максимального количества игроков в команде
     */
    public function getNumberMax($id)
    {
        $pdo = Db::instance();
        return $pdo->pdo->query("SELECT `number_max` FROM `room` WHERE `id` = '{$id}'");
    }

    /**
     * Обновить число игроков в комнате по id комнаты
     */
//    public function updateNumberNow($number, $id)
//    {
//        $pdo = Db::instance();
//        $pdo->updateRow('UPDATE `room` SET `number_now` = ? WHERE `id` = ?', [$number, $id]);
//    }

    public function calculateNumberNow($id = "") {
        $pdo = Db::instance();
        $pdo = $pdo->pdo->query("SELECT `id` FROM `u` WHERE `current_room` = '{$this->id}'");
        return $this->number_now = $pdo->rowCount();
    }

    public function updateNumberNow()
    {
        $number = $this->calculateNumberNow();
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `room` SET `number_now` = ? WHERE `id` = ?', [$number, $this->id]);
    }

    /**
     * Проверяем есть ли комната по id комнаты
     */
    public function issetRoom()
    {
        $pdo = Db::instance();
        $room = $pdo->getRow("SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)");
        // Проверяем комнату на существование
        if ($room) {
            // Если комната существует то мы проверяем ее статус
            if ($room['room_condition'] != 1) {
                // Если она пуста возвращаем true
                $this->id = $room['id'];
                return true;
            }else{
                // Если не пуста возвращаем false
                return false;
            }
        }else{
            // Если комната не существует возвращаем false
            return false;
        }
    }

    public function getRoomId() {
        return $this->id;
    }

    public function createEmptyRoom()
    {
        $pdo = Db::instance();
        $stmt = $pdo->pdo->prepare("INSERT INTO `room` () VALUES ()");
        $stmt->execute();
    }


    /**
     * Получаем количество игрокров в комнате под номером $number
     */

    public function getPhotos($id)
    {
        $pdo = Db::instance();
        return $pdo->getRows("SELECT photo FROM `u` WHERE current_room = '{$id}'");
    }


}