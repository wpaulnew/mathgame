<?php

use app\models\Login;
use vendor\libs\Session;
use vendor\core\Controller;


class LoginController extends Controller
{
    public function indexAction($info = '')
    {
        if (Session::isSession('login')) {
            $this->Redirect('/home/id/' . Session::get('id'), false);
        } else {
            if ($this->isAjax()) {

                if ($this->isPost('login') && $this->isPost('password')) {

                    if ($this->POST('login') == '' && $this->POST('password') == '') {
                        $exit = [
                            'correct' => false,
                        ];
                        exit(json_encode($exit));
                    }

                    $login = new Login();

                    $l = htmlspecialchars($_POST['login']);
                    $p = htmlspecialchars($_POST['password']);

                    if ($login->addU($l, $p)) {
                        $id = $login->getUId($l, $p);
                        // Если в конце концов все хорошо, создаем сесию и перенаправляем
                        Session::create('id', $id['id']);
                        Session::create('login', $l);
                        Session::create('password', $p);
                        if (isset($_SESSION['current_room'])) {
                            unset($_SESSION['current_room']);
                        }
                        $exit = [
                            'correct' => true,
                            'id' => Session::get('id')
                        ];
                        exit(json_encode($exit));
                    } else {
                        $exit = [
                            'correct' => false,
                        ];
                        exit(json_encode($exit));
                    }
                }
            }
        }
        $this->view->render('login/index', array());
        return true;
    }

    public function exitAction()
    {
        Session::remove('login');
        Session::remove('password');
        $this->Redirect('/login', false);
        return true;
    }
}