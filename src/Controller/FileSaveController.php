<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\File;
use Cleitoncunha\Bird\Model\Repository\FileRepository;
use DI\Test\PerformanceTest\Get\F;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class FileSaveController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private FileRepository $fileRepository,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();

        $fileName = htmlspecialchars($queryParams['name'], ENT_QUOTES, 'UTF-8');

        $topicId = filter_var($queryParams['topic_id'], FILTER_VALIDATE_INT);

        $previousUrl = $_SESSION['previous_url'];

        $files = $request->getUploadedFiles();

        $uploadedFile = $files['file'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $sluggedName = strtolower(
                trim(
                    preg_replace('/[^A-Za-z0-9-]+/',
                        '-',
                        $fileName
                    )
                )
            );

            $safeFileName = $sluggedName . '_' . uniqid('uploaded_file');

            $file = new File(
                id: 0,
                name: $fileName,
                fileName: $safeFileName,
                topicId: $topicId
            );

            if ($this->fileRepository->save($file)) {
                $uploadedFile->moveTo(__DIR__ . '/../../public/assets/files/uploads/' . $safeFileName);
            }
        } else {
            $this->addErrorMessage('Erro ao adicionar o arquivo');
        }

        return new Response(302, ['Location' => $previousUrl]);
    }
}