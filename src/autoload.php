<?php
use Pyncer\Snyppet\Snyppet;
use Pyncer\Snyppet\SnyppetManager;

SnyppetManager::register(new Snyppet(
    'role',
    dirname(__DIR__),
    [
        'access' => ['Role']
    ],
));
