<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Repository\FileRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class FileRemoveController implements RequestHandlerInterface
{
    private const string FILE_PATH = __DIR__ . '/../../public/assets/files/uploads/';

    use ErrorMessageTrait;

    public function __construct(
        private FileRepository $fileRepository,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);

        $previousUrl = $_SESSION['previous_url'];

        if ($id > 0) {
            $file = $this->fileRepository->findById($id)[0];

            $filePath = self::FILE_PATH . $file->fileName;

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            if (!$this->fileRepository->remove($id)) {
                $this->addErrorMessage('Error on deleting file');
            }
        } else {
            $this->addErrorMessage('Error on deleting file');
        }

        return new Response(302, ['Location' => $previousUrl]);
    }
}