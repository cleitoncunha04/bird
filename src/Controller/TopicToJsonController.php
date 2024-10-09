<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Model\Entity\File;
use Cleitoncunha\Bird\Model\Entity\Topic;
use Cleitoncunha\Bird\Model\Repository\TopicRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class TopicToJsonController implements RequestHandlerInterface
{
    public function __construct(
        private TopicRepository $topicRepository,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $topics = array_map(function (Topic $topic): array {
            return [
                "id" => $topic->id,
                "name" => $topic->name,
                "files" => array_map(function (File $file): array {
                    return [
                        "id" => $file->id,
                        "name" => $file->name,
                        "file_name" => '/assets/files/uploads/' . $file->fileName
                    ];
                }, $topic->getFiles())
            ];
        }, $this->topicRepository->findAll());

        return new Response(200, ['Content-Type' => 'application/json'], json_encode($topics));
    }
}