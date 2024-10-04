<?php


use Cleitoncunha\Bird\Controller\{
    AddExistentTopicInDisiciplineController,
    DisciplineListController,
    DisciplineRemoveController,
    DisciplineSaveController,
    DisciplineToJsonController,
    LoginController,
    LoginFormController,
    LogoutController,
    SignupController,
    SignupFormController,
    TopicListController,
    TopicSaveController,
    TopicsListDisciplineController,
    DisciplinesTopicsToJsonController,
    TopicToJsonController
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
    'GET|/topics-discipline' => TopicsListDisciplineController::class,
    'GET|/disciplines-topics-json' => DisciplinesTopicsToJsonController::class,
    'POST|/save-topic' => TopicSaveController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/topics-json' => TopicToJsonController::class,
    'GET|/topics' => TopicListController::class,
    'GET|/save-existent-topic' => AddExistentTopicInDisiciplineController::class,
];