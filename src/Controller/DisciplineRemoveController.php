<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\Discipline;
use Cleitoncunha\Bird\Model\Repository\DisciplineRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class DisciplineRemoveController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    private const string IMAGE_PATH = __DIR__ . "/../../public/assets/images/uploads/disciplines/";

    public function __construct(
        private DisciplineRepository $disciplineRepository,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id'], FILTER_SANITIZE_NUMBER_INT);

        if (!$id) {
            $this->addErrorMessage("ID da disciplina inválido");
        } else {
            $discipline = $this->disciplineRepository->findById($id)[0];

            $currentImagePath = self::IMAGE_PATH . $discipline->getBannerImage();

            if (file_exists($currentImagePath) && $discipline->getBannerImage() != "banner-teste-2.jpg") {
                unlink($currentImagePath);

                $this->disciplineRepository->updateBannerImageToNull($id);
            }

            if (!$this->disciplineRepository->remove($id)) {
                $this->addErrorMessage("Erro ao remover a disciplina");
            }
        }

        return new Response(302, ['Location' => '/']);
    }
}