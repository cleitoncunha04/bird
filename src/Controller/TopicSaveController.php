<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\Topic;
use Cleitoncunha\Bird\Model\Repository\TopicRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TopicSaveController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private readonly TopicRepository $topicRepository,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();

        $topicId = filter_var($queryParams['id'], FILTER_VALIDATE_INT);

        $topicName = htmlentities($queryParams['name'], ENT_QUOTES, 'UTF-8');

        $previousUrl = $_SESSION['previous_url'];

        $disciplineId = (int) mb_substr($previousUrl, -1);

        if (!$topicName) {
            $this->addErrorMessage("Invalid Topic Name");
        }

        $topic = new Topic(
            $topicId,
            $topicName
        );

        if (!$this->topicRepository->save($topic)) {
            $this->addErrorMessage("Error saving Topic");
        }

        if ($topic->id === 0) {
            $topicReserchead = $this->topicRepository->findByName($topicName)[0];

           $this->topicRepository->addTopicInDiscipline($topicReserchead->id, $disciplineId);
        }

        return new Response(302, ['Location' => $previousUrl]);
    }
}