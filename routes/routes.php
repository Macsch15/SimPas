<?php

return [
    'routes' => [
        '/' => [
            'controller' => 'SimPas\Pastebin\Controller',
            'action' => 'index',
            'static' => true,
        ],
        '/paste/{id}' => [
            'controller' => 'SimPas\Pastebin\Controller',
            'action' => 'read',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/raw/{id}' => [
            'controller' => 'SimPas\Pastebin\Controller',
            'action' => 'rawMode',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/rules' => [
            'template' => 'Rules',
            'static'   => true,
        ],
        '/cookies' => [
            'template' => 'CookiesPolicy',
            'static'   => true,
        ],
        '/latest' => [
            'controller' => 'SimPas\Pastebin\LatestPastes',
            'action' => 'index',
            'static' => true,
        ],
        '/abuse/{id}' => [
            'controller' => 'SimPas\Pastebin\ReportAbuse',
            'action' => 'index',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/abuse/{id}/results' => [
            'controller' => 'SimPas\Pastebin\ReportAbuse',
            'action' => 'results',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/download/{id}' => [
            'controller' => 'SimPas\Pastebin\Controller',
            'action' => 'download',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/embed/{id}' => [
            'controller' => 'SimPas\Pastebin\Controller',
            'action' => 'embed',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/api/{id}' => [
            'controller' => 'SimPas\Pastebin\Controller',
            'action' => 'jsonApi',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/compare/{left}/with/{right}' => [
            'controller' => 'SimPas\Pastebin\Compare',
            'action' => 'compare',
            'requirements' => [
                'left' => '\d+',
                'right' => '\d+',
            ],
        ],
        '/compare/{left}' => [
            'controller' => 'SimPas\Pastebin\Compare',
            'action' => 'form',
            'requirements' => [
                'left' => '\d+',
            ],
        ],
    ],
];
