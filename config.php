<?php
use Project\ConfigurationInterface;

return [
    'project' => [
        'name' => 'Heidelauf',
        'namespace' => 'Project'
    ],
    'template' => [
        'name' => 'default',
        'dir' =>  '/default',
        'main_css_path' => '/css/main.css'
    ],
    'database' => [
        'host' => ConfigurationInterface::DEFAULT_SERVER,
        ConfigurationInterface::USER => 'root',
        ConfigurationInterface::PASS => '',
        'database_name' => 'heidelauf'
    ],
    'controller' => [
        'namespace' => 'Controller'
    ],
    'donationPerRound' => 1,
    'startingTime' => '2018-06-21 13:19:00',
    'endTime' => '2018-06-22 13:23:00',
    'transponderFile' => 'transponder.txt'
];