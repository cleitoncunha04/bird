<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Repository\TopicRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class TopicRemoveController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private TopicRepository $topicRepository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $topicId = filter_var($queryParams['id'], FILTER_VALIDATE_INT);

        $previousUrl = $_SESSION['previous_url'];

        if (!$this->topicRepository->remove($topicId)) {
            $this->addErrorMessage('Erro ao remover o tema');
        }

        return new Response(302, ['Location' => $previousUrl]);
    }
}