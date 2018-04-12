<?php

//namespace app\models;

use vendor\core\Db;

class Room
{
    protected $id;
    protected $number_max;
    protected $number_now;
    protected $room_condition = true;
    protected $winner_id;

    public function __construct()
    {

    }

    public function create($login)
    {
        $pdo = Db::instance();
        /**
         * Сперва сделаем проверку.
         * Есть ли в базе уже комната и пуста ли она
         */
        $room = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');

        if ($room) {
            if ($room['room_condition'] == 0) {

                $stmt = $pdo->pdo->prepare("INSERT INTO `room_u` (id_room, login_u) VALUES (:id_room, :login_u)");
                $stmt->bindParam(':id_room', $room['id']);
                $stmt->bindParam(':login_u', $login);
                $stmt->execute();

                $pdo->updateRow('UPDATE `u` SET `current_room` = ? WHERE `login` = ?', [$room['id'], $login]);

                /**
                 * Сдесь возмем из табл. room_u, и посчиатем сколько в комнате людей и запишим сюда
                 */
                $stmt = $pdo->pdo->query("SELECT `id` FROM `u` WHERE `current_room` = '{$room['id']}'");
                $numberNow = $stmt->rowCount();
//                print_r($numberNow);

                $update = $pdo->updateRow('UPDATE `room` SET `number_now` = ? WHERE `id` = ?', [$numberNow, $room['id']]);
                if ($update) {
                    echo "I am ready";
                }
            }
        } else {
            $stmt = $pdo->pdo->prepare("INSERT INTO `room` () VALUES ()");
            $stmt->execute();

            $allRoom = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
            if ($allRoom['room_condition'] == 0) {

                $pdo->updateRow('UPDATE `u` SET `current_room` = ? WHERE `login` = ?', [$room['id'], $login]);
                /**
                 * Сдесь возмем из табл. room_u, и посчиатем сколько в комнате людей и запишим сюда
                 */
                $stmt = $pdo->pdo->query("SELECT `id` FROM `u` WHERE `current_room` = '{$room['id']}'");
                $numberNow = $stmt->rowCount();
//                print_r($numberNow);

                $update = $pdo->updateRow('UPDATE `room` SET `number_now` = ? WHERE `id` = ?', [$numberNow, $room['id']]);
                if ($update) {
                    echo "I am ready";
                }
            }
        }
//        //-------
////        $stmt = $pdo->pdo->prepare("INSERT INTO `room` () VALUES ()");
////        $stmt->execute();
//
//        /**
//         * Сдесь возмем последгюю комнату свободную естественно, ее id
//         */
//
////        $stmt = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
////
////        $idRoom = $stmt['id'];
//
////        $stmt = $pdo->pdo->prepare("INSERT INTO `room_u` (id_room, login_u) VALUES (:id_room, :login_u)");
////        $stmt->bindParam(':id_room', $idRoom);
////        $stmt->bindParam(':login_u', $login);
////        $stmt->execute();
//
////
////        $stmt = $pdo->pdo->query("SELECT * FROM `room_u` WHERE `id_room` = '{$idRoom}'");
////        $numberNow = $stmt->rowCount();
////        print_r($numberNow);
//
        return true;
    }

    public function issetRoom() {
        $pdo = Db::instance();
        $room = $pdo->getRow('SELECT * FROM `room` WHERE id=(SELECT MAX(id) FROM `room`)');
    }

    /**
     * Получаем количество игрокров в комнате под номером $number
     */

    public function getPhotos($number)
    {
        $pdo = Db::instance();
//        $stmt = $pdo->pdo->query("SELECT `number_now` FROM `room` WHERE `id` = '{$number}'");
//        return $stmt->rowCount()
//        $stmt = $pdo->getRows("SELECT photo FROM u LEFT OUTER JOIN room_u d ON u.login = '{$login}'");
        return $pdo->getRows("SELECT photo FROM `u` WHERE current_room = '{$number}'");
    }

//    public function findProfile($login, $password)
//    {
//        $pdo = Db::instance();
//        $query = $pdo->pdo->query("SELECT * FROM `u` WHERE `login` = '{$login}' AND `password` = '{$password}'");
//        return $query->rowCount();
//    }

}