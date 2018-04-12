<?php

use vendor\libs\Session;
use vendor\core\Controller;

class ErrorController extends Controller
{
    public function indexAction()
    {
        if (!Session::isSession('login')) {
            $this->Redirect('/login');
        } else {
            $this->view->render('404/index', array());
            return true;
        }
    }
}