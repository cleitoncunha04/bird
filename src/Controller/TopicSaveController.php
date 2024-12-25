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

        parse_str(parse_url($previousUrl, PHP_URL_QUERY), $params);

        $disciplineId = (int) $params['discipline_id'] ?? null;

        if (!$topicName) {
            $this->addErrorMessage("Nome inválido para o tema");
        }

        $topic = new Topic(
            $topicId,
            $topicName,
        );

        $alreadyExists = $this->topicRepository->findByName($topic->name);

        if (count($alreadyExists) > 0 && $topic->id == 0) {
            $this->addErrorMessage("Tema já existe");

            return new Response(302, ['Location' => $previousUrl]);
        }

        if (!$this->topicRepository->save($topic)) {
            $this->addErrorMessage("Erro ao salvar o tema");
        }

        if ($topic->id === 0) {
            $topicResearched  = $this->topicRepository->findByName($topic->name)[0];

            $this->topicRepository->addTopicInDiscipline($topicResearched->id, $disciplineId);
        }

        return new Response(302, ['Location' => $previousUrl]);
    }
}