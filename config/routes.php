<?php

return [
    '/' => 'site/index',
    'login' => 'site/login',
    'user/<id:\d+>' => 'user/show',
    'user/create' => 'user/create',
    'user/delete' => 'user/delete',
    'group/<id:\d+>' => 'group/show',
    'group/create' => 'group/create',
    'group/delete' => 'group/delete',
    'group/add-user' => 'group/addUser',
    'group/<id:\d+>/users' => 'group/showUsers',
    'challenge/<id:\d+>' => 'challenge/show',
    'challenge/create' => 'challenge/create',
    'challenge/<id:\d+>/edit' => 'challenge/edit',
    'challenge/<id:\d+>/delete' => 'challenge/delete',
];