<?php

namespace vendor\core;

use vendor\core\View;

class Controller
{
    protected $view;

    function __construct()
    {
        $this->view = new View();
    }

    public function isAjax()
    {
        return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";
    }

    public function Redirect($url, $permanent = false)
    {
        if (headers_sent() === false) {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }

        exit();
    }

    public function isPost($information)
    {
        if (isset($_POST[$information])) {
            return true;
        }
        return false;
    }
    public function POST($key) {
        return $_POST[$key];
    }

    // другие полезные методы вроде redirect($url);
}