<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Model\Repository\DisciplineRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


readonly class DisciplineListController implements RequestHandlerInterface
{
    public function __construct(
        private DisciplineRepository $disciplineRepository,
        private Engine               $templates
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $disciplines = $this->disciplineRepository->findAll();

        return new Response(status: 302, body: $this->templates->render('vw_disciplines',
            ['disciplines' => $disciplines]));
    }
}