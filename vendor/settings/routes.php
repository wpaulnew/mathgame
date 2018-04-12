<?php

return [
    'room/id/([0-9]+)/winner' => 'room/winner/$1',
    'room/id/([0-9]+)/waiting' => 'room/waiting/$1',
    'room/id/([0-9]+)' => 'room/index/$1',
    'room/menu' => 'room/menu',
    'room/exit' => 'room/exit',
    'room/update' => 'room/update',

    'login' => 'login/index',
    'exit' => 'login/exit',

    'home/id/([0-9]+)' => 'home/index/$1',
    'error/' => 'error/index',
    'error' => 'error/index',

    '^$' => 'login/index'
];