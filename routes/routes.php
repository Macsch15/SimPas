<?php

return [
    'routes' => [
        '/' => [
            'controller' => 'Application\Pastebin\Controller',
            'action'     => 'index',
            'static'     => true,
        ],
        '/paste/{id}' => [
            'controller'   => 'Application\Pastebin\Controller',
            'action'       => 'read',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/raw/{id}' => [
            'controller'   => 'Application\Pastebin\Controller',
            'action'       => 'rawMode',
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
            'controller' => 'Application\Pastebin\LatestPastes',
            'action'     => 'index',
            'static'     => true,
        ],
        '/abuse/{id}' => [
            'controller'   => 'Application\Pastebin\ReportAbuse',
            'action'       => 'index',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/abuse/{id}/results' => [
            'controller'   => 'Application\Pastebin\ReportAbuse',
            'action'       => 'results',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/download/{id}' => [
            'controller'   => 'Application\Pastebin\Controller',
            'action'       => 'download',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/embed/{id}' => [
            'controller'   => 'Application\Pastebin\Controller',
            'action'       => 'embed',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/api/{id}' => [
            'controller'   => 'Application\Pastebin\Controller',
            'action'       => 'jsonApi',
            'requirements' => [
                'id' => '\d+',
            ],
        ],
        '/compare/{left}/with/{right}' => [
            'controller'   => 'Application\Pastebin\Compare',
            'action'       => 'compare',
            'requirements' => [
                'left'  => '\d+',
                'right' => '\d+',
            ],
        ],
        '/compare/{left}' => [
            'controller'   => 'Application\Pastebin\Compare',
            'action'       => 'form',
            'requirements' => [
                'left' => '\d+',
            ],
        ],
    ],
];
