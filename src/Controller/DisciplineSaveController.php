<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\Discipline;
use Cleitoncunha\Bird\Model\Repository\DisciplineRepository;
use finfo;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function var_dump;

readonly class DisciplineSaveController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private DisciplineRepository $disciplineRepository,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        $name = htmlspecialchars($queryParams['name'], ENT_QUOTES, 'UTF-8');

        if (!$name) {
            $this->addErrorMessage('Campo "nome" é obrigatório.');

            return new Response(302, ['Location' => '/']);
        }

        $discipline = new Discipline(
            id: $id,
            name: $name
        );

        $alreadyExists = $this->disciplineRepository->findByName($name);

        if (count($alreadyExists) > 0) {
            $this->addErrorMessage('Disciplina já existe.');

            return new Response(302, ['Location' => '/']);
        }

        $files = $request->getUploadedFiles();

        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);

            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');

            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, 'image/')) {
                $sluggedName = strtolower(
                    trim(
                        preg_replace('/[^A-Za-z0-9-]+/',
                            '-',
                            pathinfo($uploadedImage->getClientFilename(), PATHINFO_FILENAME))
                    )
                );

                $safeFileName = uniqid('upload_discipline') . '_' . $sluggedName;

                $discipline->setBannerImage($safeFileName);

                $uploadedImage->moveTo(__DIR__ . '/../../public/assets/images/uploads/disciplines/' . $safeFileName);
            }
        }

        if (!$this->disciplineRepository->save($discipline)) {
            $this->addErrorMessage("Erro ao salvar essa disciplina.");
        }

        return new Response(302, ['Location' => '/']);
    }
}