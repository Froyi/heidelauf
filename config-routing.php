<?php
return [
    'route' => [
        'index' => [
            'controller' => 'IndexController',
            'action' => 'indexAction'
        ],
        'admin' => [
            'controller' => 'IndexController',
            'action' => 'adminAction'
        ],
        'insertTeam' => [
            'controller' => 'IndexController',
            'action' => 'insertTeamAction'
        ],
        'deleteTeam' => [
            'controller' => 'IndexController',
            'action' => 'deleteTeamAction'
        ],
        'editTeam' => [
            'controller' => 'JsonController',
            'action' => 'editTeamAction'
        ],
        'editTeamSubmit' => [
            'controller' => 'IndexController',
            'action' => 'editTeamSubmitAction'
        ],
        'refresh' => [
            'controller' => 'JsonController',
            'action' => 'refreshAction'
        ],
        'finish' => [
            'controller' => 'IndexController',
            'action' => 'finishAction'
        ],
        'test' => [
            'controller' => 'IndexController',
            'action' => 'testAction'
        ]
    ]
];