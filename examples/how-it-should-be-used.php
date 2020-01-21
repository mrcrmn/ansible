<?php

$playbook = new Playbook;

$playbook->hosts([
    'all' => [
        'mail.example.com',
        '192.168.178.10',
        '192.168.178.11',
        '192.168.178.12',
    ],
    'webservers' => [
        '192.168.178.10',
        '192.168.178.11',
    ],
    'dbservers' => [
        '192.168.178.12',
    ]
]);

// Or

$playbook->hosts([
    'mail.example.com',
    '192.168.178.10',
    '192.168.178.11',
    '192.168.178.12',
]);

$playbook->group('webservers', [
    '192.168.178.10',
    '192.168.178.11',
]);

$playbook->group('dbservers', [
    '192.168.178.12',
]);

$playbook->fromRecipes('webservers', [
    new InstallNginx,
    new InstallPHP('7.4'),
    new InstallNode('12'),
    new DeployApp('https://github.com/mrcrmn/path-to-project.git'),
]);

$playbook->fromRecipes('dbservers', [
    new InstallMysql('5.7', [
        'database' => 'database_name',
        'user' => 'mysql_user',
        'password' => 'mysql_password'
    ])
]);