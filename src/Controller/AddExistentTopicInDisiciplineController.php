<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Repository\TopicRepository;
use mysql_xdevapi\Exception;
use Nyholm\Psr7\Response;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class AddExistentTopicInDisiciplineController implements RequestHandlerInterface
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

        $previousUrl = $_SESSION['previous_url'] ?? null;

        $displineId = (int) mb_substr($previousUrl, -1);

        $topic = $this->topicRepository->findById($topicId)[0];

        if (!$topic) {
            $this->addErrorMessage('Topic not found');
        } else {
            try {
                $this->topicRepository->addTopicInDiscipline($topic->id, $displineId);
            } catch (PDOException $e) {
                $this->addErrorMessage('Discipline already has pinned this topic');
            }
        }

        return new Response(302, ['Location' => $previousUrl]);
    }
}