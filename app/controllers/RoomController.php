<?php

use app\models\Room;
use app\models\House;
use \app\models\Battle;
use \app\models\Players;
use vendor\libs\Session;
use vendor\core\Controller;

class RoomController extends Controller
{

    // Процес игры
    public function indexAction($id)
    {
        // $now - какой раунд сейчас
        // $end - из скольки
        if (!Session::isSession('login')) {
            $this->Redirect('/login');
        } else {
            $battle = new Battle();
            $question = $battle->getExample($id);
            if ($this->isAjax()) {
                if ($this->isPost('oneexample')) {
                    $battle = new Battle();

                    $number = $battle->calculateRoundNow($id);

                    if ($number == 0) {
                        $exit = [
                            'correct' => false,
                            'id' => $id,
                        ];
                        exit(json_encode($exit));
                    }

                    $count = $battle->calculatePlayerInRoom($id);
                    if (!$count) {

                        $answered = $battle->getWinner($id);
                        $array = [];
                        foreach ($answered as $answer) {
                            $array[] = $answer['answered'];
                        }
                        $winner = $battle->countElement($array);

                        // Запишем победителя в таблицу
                        $battle->setWinner($winner, $id);

                        // Обновим число побед
                        $battle->updateWin($winner);


                        $id = $battle->clearBattle($id);

                        $exit = [
                            'correct' => false,
                            'id' => $id,
                        ];
                        exit(json_encode($exit));
                    }

                    if ($number == $battle->getRoundMax()) {
                        /*
                         * Делаем подсчет в баттле по id
                         */

                        $answered = $battle->getWinner($id);
                        $array = [];
                        foreach ($answered as $answer) {
                            $array[] = $answer['answered'];
                        }
                        $winner = $battle->countElement($array);

                        // Запишем победителя в таблицу
                        $battle->setWinner($winner, $id);

                        // Обновим число побед
                        $battle->updateWin($winner);


                        $id = $battle->clearBattle($id);
                        $exit = [
                            'correct' => false,
                            'id' => $id,
                        ];
                        exit(json_encode($exit));
                    } else {
                        $question = $battle->getExample($id);
                        $exit = [
                            'correct' => true,
                            'question' => $question,
                        ];
//                        $battle->clearBattle($id);
                        exit(json_encode($exit));
                    }

                }
                if ($this->isPost('answer')) {
                    $battle = new Battle();
                    /**
                     * Переделать под OOP,
                     * в месте с set и get
                     */
                    $question = $this->POST('question');
                    $answer = $this->POST('answer');
                    $answering = $this->POST('answering');



                    //  Проверяем правильный ответ 
                    $correct = $battle->correctAnswer($id, $question, $answer, $answering);

//                    echo 'Question : ' . $question;
//                    print_r($correct);
//                    exit();

                    if ($correct) {
                        $battle->updateQuestionCondition($question);
                        $battle->createQuestion($id);
                        $number = $battle->calculateRoundNow($id);
                        $battle->updateRoundNow($id, $number);
                        $exit = [
                            'correct' => true,
                        ];
                        exit(json_encode($exit));
//                        exit(json_encode($exit));
                    } else {
                        $exit = [
                            'correct' => false,
                            'id' => Session::get('id') // id того кто допустил ошибку
                        ];
                        exit(json_encode($exit));
                    }
                }
            }
        }
        $this->view->render('room/index', array(
            'question' => $question
        ));
        return true;
    }

    // Меню для старта
    public function menuAction()
    {
        if (!Session::isSession('login')) {
            $this->Redirect('/login');
        } else {
            if ($this->isAjax()) {
                if ($this->isPost('2')) {
                    $house = new House();
                    // Проверяем существует ли комната
                    if ($house->issetRoom('2')) {
                        // Комната существует, получаем ее информацию
                        $room = $house->getRoomFromEnd();
                        // Устанавлеваем id
                        $house->setRoomKey($room['id']);
                        $house->addPlayerToRoom(Session::get('id'));
                        Session::create('current_room', $house->getRoomKey());
                        // Обновляем количесто учасников в комнате
                        $house->countPlayersInRoom();
                        $house->updateNumberNow();
                        $house->updateCondition();
                        exit($house->getRoomKey());
                    } else {
                        $room = new Room('2');
                        $house->setRoomKey($room->getRoomKey());
                        $house->addPlayerToRoom(Session::get('id'));
                        Session::create('current_room', $house->getRoomKey());
                        $house->countPlayersInRoom();
                        $house->updateNumberNow();
                        $house->updateCondition();
                        exit($house->getRoomKey());
                    }
                   
                }
                if ($this->isPost('3')) {
                    $house = new House();
                    // Проверяем существует ли комната
                    if ($house->issetRoom('3')) {
                        // Комната существует, получаем ее информацию
                        $room = $house->getRoomFromEnd();
                        // Устанавлеваем id
                        $house->setRoomKey($room['id']);
                        $house->addPlayerToRoom(Session::get('id'));
                        Session::create('current_room', $house->getRoomKey());
                        // Обновляем количесто учасников в комнате
                        $house->countPlayersInRoom();
                        $house->updateNumberNow();
                        $house->updateCondition();
                        exit($house->getRoomKey());
                    } else {
                        $room = new Room('3');
                        $house->setRoomKey($room->getRoomKey());
                        $house->addPlayerToRoom(Session::get('id'));
                        Session::create('current_room', $house->getRoomKey());
                        $house->countPlayersInRoom();
                        $house->updateNumberNow();
                        $house->updateCondition();
                        exit($house->getRoomKey());
                    }
                }
            }
        }
        $this->view->render('room/menu', array());
        return true;

    }

    // Ожидание игроков
    public function waitingAction($id)
    {
        if (!Session::isSession('login')) {
            $this->Redirect('/login');
        } else {
            if ($this->isAjax()) {
                if ($this->isPost('waiting')) {
                    $house = new House();
                    $house->setRoomKey($id);
                    // Проверяем если number_now == number_max, тогда редирект
                    if ($house->numberConflict()) {
                        $number = preg_replace("/[^0-9]/", '', $this->POST('waiting'));
                        if ($id == $number) {
                            $photos = $house->getPhotos();
                            $exit = [
                                'correct' => true,
                                'photos' => []
                            ];

                            for ($i = 0; $i < count($photos); $i++) {
                                array_push($exit['photos'], '<img src="http://localhost/public/img/' . $photos[$i]['photo'] . '" class="profile-mini-icon" alt="">');
                            }
                            exit(json_encode($exit));
                        }

                    } else {
                        $battle = new Battle();
                        $battle->createQuestion($id);

                        // Считаем количество раундов, просто берем
                        // из battle количество строк где room = $id
                        $number = $battle->calculateRoundNow($id);
                        $battle->updateRoundNow($id, $number);

                        $exit = [
                            'correct' => false,
                            'id' => $id
                        ];
                        exit(json_encode($exit));
                    }


                }
            }
        }
        $this->view->render('room/waiting', array());
        return true;
    }

// Просмотр победителя
    public function winnerAction($id)
    {
        if (!Session::isSession('login')) {
            $this->Redirect('/login');
        }

        unset($_SESSION['current_room']);
        $house = new House();
        $winner = $house->getWinner($id);

        if (!$winner) {
            $this->view->render('404/index', array());
        }

        $this->view->render('win/index', array(
            'winner' => $winner
        ));
        return true;
    }

// Просто выход пока что
    public function exitAction()
    {
        $players = new Players();
        $players->update(Session::get('id'));
        unset($_SESSION['current_room']);
        $this->Redirect('/room/menu');
    }

}