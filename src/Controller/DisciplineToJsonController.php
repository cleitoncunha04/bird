<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use Cleitoncunha\Bird\Model\Repository\DisciplineRepository;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function json_encode;

readonly class DisciplineToJsonController implements RequestHandlerInterface
{
    public function __construct(
        private DisciplineRepository $disciplineRepository
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $disciplines = array_map(
            function (Discipline $discipline): array {
                $filePath = "";

                if ($discipline->getBannerImage() !== null) {
                    $filePath = "/assets/images/uploads/disciplines/" . $discipline->getBannerImage();
                }

                return [
                    'id' => $discipline->id,
                    'name' => $discipline->name,
                    'banner_image' => $filePath,
                ];
            }, $this->disciplineRepository->findAll()
        );

        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($disciplines)
        );
    }
}