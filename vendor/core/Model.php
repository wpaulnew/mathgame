<?php

use core\Db;

class Model
{
    protected $db;

    function __construct()
    {
        $this->db = Db::instance();
    }

}