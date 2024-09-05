<?php


use Cleitoncunha\Bird\Controller\LoginController;
use Cleitoncunha\Bird\Controller\LoginFormController;
use Cleitoncunha\Bird\Controller\SingupController;
use Cleitoncunha\Bird\Controller\SingupFormController;

return [
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/singup' => SingupFormController::class,
    'POST|/singup' => SingupController::class,
];