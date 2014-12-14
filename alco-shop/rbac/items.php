<?php
return [
    'user' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'user',
        ],
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
    ],
];
