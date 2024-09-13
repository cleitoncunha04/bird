<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Model\Repository\TopicRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class TopicListController implements RequestHandlerInterface
{
    public function __construct(
        private Engine $templates,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(status: 302, body: $this->templates->render('vw_topics_list'));
    }
}