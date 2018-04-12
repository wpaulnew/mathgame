<?php

namespace vendor\core;

/**class Router
{
    private $routes;

    public function __construct($routes)
    {
        if (is_array($routes)) {
            $this->routes = $routes;
        }
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                $controllerFile = APP . '/controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }
                $controllerObject = new $controllerName;
                echo $actionName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }

        }
    }
}**/
class Router
{

    private $routes;

    public function __construct($routes)
    {
        if (is_array($routes)) {
            $this->routes = $routes;
        }
    }

    // Метод получает URI. Несколько вариантов представлены для надёжности.
    function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        if (!empty($_SERVER['PATH_INFO'])) {
            return trim($_SERVER['PATH_INFO'], '/');
        }

        if (!empty($_SERVER['QUERY_STRING'])) {
            return trim($_SERVER['PATH_INFO'], '/');
        }
    }

    function run()
    {
        // Получаем URI.
        $uri = $this->getURI();
//        echo "<pre>";
//        print_r($uri);
        // Пытаемся применить к нему правила из конфигуации.
        foreach ($this->routes as $pattern => $route) {

            // Если правило совпало.
            if (preg_match("~$pattern~", $uri)) {
                // Получаем внутренний путь из внешнего согласно правилу.
//                print_r($uri);
                $internalRoute = preg_replace("~$pattern~", $route, $uri); // В случае ошибки заменить #~ на ~
//                print_r($internalRoute);
                // Разбиваем внутренний путь на сегменты.
                $segments = explode('/', $internalRoute);
//                print_r($segments);
                // Первый сегмент — контроллер.
                $controller = ucfirst(array_shift($segments)) . 'Controller';
                // Второй — действие.
                $action = lcfirst(array_shift($segments)) . "Action";
//                echo $action;
                // Остальные сегменты — параметры.
                $parameters = $segments;

                // Подключаем файл контроллера, если он имеется
                $controllerFile = APP . '/controllers/' . $controller . '.php';
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controller;

                // Если не загружен нужный класс контроллера или в нём нет
                // нужного метода — 404
//                if (!is_callable(array($controller, $action))) {
//                    header("HTTP/1.0 404 Not Found");
//                    return;
//                }

                // Вызываем действие контроллера с параметрами

                if (method_exists($controllerObject, $action)) {
                    $result = call_user_func_array(array($controllerObject, $action), $parameters);
                }
//                if ($result != null) {
//                    break;
//                }
            }
        }

        // Ничего не применилось. 404.
//        header("HTTP/1.0 404 Not Found");
        //require (FRONTEND . "404.html");
        return;
    }
}