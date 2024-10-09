<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use Cleitoncunha\Bird\Model\Entity\Topic;  // Supondo que exista a entidade Topic
use Cleitoncunha\Bird\Model\Repository\DisciplineRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function json_encode;

readonly class DisciplinesTopicsToJsonController implements RequestHandlerInterface
{
    public function __construct(
        private DisciplineRepository $disciplineRepository
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Obtém os parâmetros da URL
        $queryParams = $request->getQueryParams();
        $disciplineId = filter_var($queryParams['discipline_id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        // Busca todas as disciplinas com tópicos
        $disciplines = array_map(
            function (Discipline $discipline): array {
                $filePath = "";

                if ($discipline->getBannerImage() !== null) {
                    $filePath = "/assets/images/uploads/disciplines/" . $discipline->getBannerImage();
                }

                return [
                    'discipline_id' => $discipline->id,
                    'discipline_name' => $discipline->name,
                    'discipline_banner_image' => $filePath,
                    'topics' => array_map(function ($topic) {
                        return [
                            'id' => $topic->id,
                            'name' => $topic->name,
                            'files' => array_map(function ($file) {
                                return [
                                    'id' => $file->id,
                                    'name' => $file->name,
                                    'file_name' => '/assets/files/uploads/' . $file->fileName
                                ];
                            }, $topic->getFiles())
                        ];
                    }, $discipline->getTopics())
                ];
            },
            $this->disciplineRepository->findDisciplinesWithTopics()
        );

        // Se o discipline_id for passado, faz o filtro
        if ($disciplineId !== null) {
            $disciplines = array_filter($disciplines, function ($discipline) use ($disciplineId) {
                return $discipline['discipline_id'] == $disciplineId;
            });

            if (empty($disciplines)) {
                return new Response(
                    404,
                    ['Content-Type' => 'application/json'],
                    json_encode(['error' => 'Not found disciplines'])
                );
            }
        }

        // Retorna o JSON
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($disciplines)
        );
    }

}
