<?php

use \app\models\Home;
use vendor\libs\Session;
use vendor\core\Controller;

class HomeController extends Controller
{
    public function indexAction($id)
    {
        if (!Session::isSession('login')) {
            $this->Redirect('/login');
        }else{
            $home = new Home();
            $info = $home->getPlayerInfo($id);
            if (!$info) {
                $this->view->render('404/index', array());
            }
            $this->view->render('home/index', array(
                'info' => $info
            ));
        }
        return true;
    }
}