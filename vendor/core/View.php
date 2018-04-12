<?php

namespace vendor\core;

class View
{
    public $layout = "layout";
    public $description = "description";
    public $author = "author";
    public $keywords = "keywords";

    // получить отрендеренный шаблон с параметрами $params
    function fetchPartial($template, $params = array())
    {
        extract($params);
        ob_start();
        require_once(VIEWS .'/'. $template . '.php');
        return ob_get_clean();
    }

    // вывести отрендеренный шаблон с параметрами $params
    function renderPartial($template, $params = array())
    {
        echo $this->fetchPartial($template, $params);
    }

    // получить отрендеренный в переменную $content layout-а
    // шаблон с параметрами $params
    function fetch($template, $params = array())
    {
        $content = $this->fetchPartial($template, $params);
        return $this->fetchPartial($this->layout, array(
                'description' => $this->description,
                'author' => $this->author,
                'keywords' => $this->keywords,
                'content' => $content
            )
        );
    }

    // вывести отрендеренный в переменную $content layout-а
    // шаблон с параметрами $params
    function render($template, $params = array())
    {
        echo $this->fetch($template, $params);
    }
}
/**
class View
{
    private $data = [];

    private $render = FALSE;

    function fetchPartial($template, $params = array())
    {
        extract($params);
        ob_start();
        require(VIEWS .'/'. $template . '.php');
        return ob_get_clean();
    }

    public function require_default_template($template, $params) {
        $content = $this->fetchPartial($template, $params);
    }

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function render($template) {
        try {
            $file = VIEWS . '/' . strtolower($template) . '.php';

            if (file_exists($file)) {
                $this->render = $file;
                extract($this->data);
                require_once($file);
            } else {
                throw new \Exception('Template ' . $template . ' not found!');
            }
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        extract($this->data);
        if (file_exists($this->render)) {
            require_once($this->render);
        }

    }
}
**/