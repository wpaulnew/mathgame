<?php

namespace app\models;

use vendor\core\Db;

class Battle
{
    protected $round_max = 9;

    public function getRoundMax()
    {
        return $this->round_max;
    }

    public function correctAnswer($id, $question, $answer, $answering)
    {
        // $id = id комнаты
        $pdo = Db::instance();
        $example = $pdo->getRow("SELECT `room`,`question` FROM `battle` WHERE `question` = '{$question}' AND `question_condition` = 0");
//        return $example;
        if ($example['room'] == $id && $example['question'] == $question) {
            $reply = $pdo->getRow("SELECT * FROM `questions` WHERE `id` = '{$question}'");
            if ($reply['answer'] == $answer) {
                // $answering - это id пользователя который правильно ответил
                $pdo->updateRow('UPDATE `battle` SET `answered` = ? WHERE `question` = ?', [$answering, $question]);
                return true;
            }
            return false;
        }
        return false;
    }

    public function createQuestion($id)
    {
        $pdo = Db::instance();
        $question = $pdo->getRow("SELECT * FROM `battle` WHERE `room` = '{$id}'");
        if ($question) {
            if ($question['question_condition'] == 0) {
                return $question;
            } else {
                $question = rand(1, 14);
                return $pdo->insertRow("INSERT INTO `battle` (room, question) VALUES (?, ?)", [$id, $question]);
            }
        }
        /**
         * Сдесь надо обратиться в базу вытянуть последний id, и задать его вторым параметром
         * в rand()
         */
        $question = rand(1, 14);
        return $pdo->insertRow("INSERT INTO `battle` (room, question) VALUES (?, ?)", [$id, $question]);
    }

    public function getNextQuestion($id)
    {
        $pdo = Db::instance();
        return $pdo->getRow("SELECT `id`,`question` FROM `battle` WHERE `id` = (SELECT MAX(id) FROM `battle` WHERE `room` = '{$id}')");
    }

//    public function getExample($id)
//    {
//        $pdo = Db::instance();
//        $question = $pdo->getRow("SELECT `question` FROM `battle` WHERE `room` = '{$id}'");
//        return $pdo->getRow("SELECT `id`,`question` FROM `questions` WHERE `id` = '{$question['question']}'");
//    }

    public function getExample($id)
    {
        $pdo = Db::instance();
//        $example = [];
        $question = $pdo->getRow("SELECT `question` AS `id` FROM `battle` WHERE `id` = (SELECT MAX(id) FROM `battle` WHERE `room` = '{$id}')");
        $example = $pdo->getRow("SELECT `id`,`question` FROM `questions` WHERE `id` = '{$question['id']}'");
//        return ['id'=>$question, 'question' => $example];
//        return [$question, $example];
        return ['id' => $example['id'], 'question' => $example['question']];
    }

    public function updateQuestionCondition($question)
    {
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `battle` SET `question_condition` = ? WHERE `question` = ?', [1, $question]);
        return true;
    }

    public function calculateRoundNow($id)
    {
        $pdo = Db::instance();
        $battle = $pdo->pdo->query("SELECT `id` FROM `battle` WHERE `room` = '{$id}'");
        return $battle->rowCount();
    }

    public function updateRoundNow($id, $number)
    {
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `room` SET `round_now` = ? WHERE `id` = ?', [$number, $id]);
    }

    /**
     * Наход какой элемент в массиве встречаесться больше всего раз
     */
    public function countElement($array)
    {
        $count = array_count_values($array);
        $element = max($count);
        return array_search($element, $count);
    }

    public function getWinner($id) {
        $pdo = Db::instance();
        $answered = $pdo->getRows("SELECT `answered` FROM `battle` WHERE `room` = '{$id}'");
//        $array = [];
//        foreach ($answered as $answer) {
//            $array[] = $answer['answered'];
//        }
//        print_r($array);
        return $answered;
    }

    // Записывем победителя в комнату
    public function setWinner($winner, $id) {
        $pdo = Db::instance();
        $pdo->updateRow('UPDATE `room` SET `winner` = ? WHERE `id` = ?', [$winner, $id]);
    }

    // Для очистки "поля битвы"
    public function clearBattle($id) {
        $pdo = Db::instance();
        $pdo->deleteRow("DELETE FROM `battle` WHERE `room` = ?", [$id]);
        return $id;
    }

    // Приимает $id - игрока
    public function updateWin($id) {
        $pdo = Db::instance();
        $count = $pdo->pdo->query("SELECT `id` FROM `room` WHERE `winner` = '{$id}'");
        $number = $count->rowCount();
        $pdo->updateRow('UPDATE `players` SET `win` = ? WHERE `id` = ?', [$number, $id]);
//        return true;
    }

    public function calculatePlayerInRoom($id)
    {
        $pdo = Db::instance();
        $battle = $pdo->pdo->query("SELECT `id` FROM `players` WHERE `current_room` = '{$id}'");
        $count = $battle->rowCount();



        $number = $pdo->getRow("SELECT `number_max` FROM `room` WHERE `id` = '{$id}'");
        if  ($count < $number['number_max']) {
            return false;
        }
        return true;
    }
}