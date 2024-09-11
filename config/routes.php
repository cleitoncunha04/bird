<?php


use Cleitoncunha\Bird\Controller\{
    DisciplineListController,
    DisciplineRemoveController,
    DisciplineSaveController,
    DisciplineToJsonController,
    LoginController,
    LoginFormController,
    SignupController,
    SignupFormController,
    TopicsListController
};

return [
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/signup' => SignupFormController::class,
    'POST|/signup' => SignupController::class,
    'GET|/' => DisciplineListController::class,
    'POST|/save-discipline' => DisciplineSaveController::class,
    'GET|/disciplines-json' => DisciplineToJsonController::class,
    'GET|/remove-discipline' => DisciplineRemoveController::class,
    'GET|/topics' => TopicsListController::class,
];