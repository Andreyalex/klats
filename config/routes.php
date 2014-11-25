<?php

return [
    'user/<id:\d+>' => 'user/show',
    'user/create' => 'user/create',
    'user/delete' => 'user/delete',
    'group/<id:\d+>' => 'group/show',
    'group/create' => 'group/create',
    'group/delete' => 'group/delete',
    'group/add-user' => 'group/addUser',
    'group/<id:\d+>/users' => 'group/showUsers',
];