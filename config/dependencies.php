<?php

use Cleitoncunha\Bird\Model\ConnectionFactory;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;

$builder = new ContainerBuilder();

$builder->addDefinitions([
    PDO::class => ConnectionFactory::getConnection(),

    Engine::class => function () {
        $templatePath = __DIR__ . '/../Views';

        return new Engine($templatePath);
    },
]);

$container = $builder->build();

return $container;