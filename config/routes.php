<?php


use Cleitoncunha\Bird\Controller\{DisciplineController,
    DisciplineListController,
    LoginController,
    LoginFormController,
    SignupController,
    SignupFormController};

return [
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/signup' => SignupFormController::class,
    'POST|/signup' => SignupController::class,
    'GET|/' => DisciplineListController::class,
    'POST|/' => DisciplineController::class,
];