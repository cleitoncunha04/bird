<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\File;
use InvalidArgumentException;
use PDO;
use PDOStatement;
use function array_map;

readonly class FileRepository implements RepositoryInterface
{
    public function __construct(
        private PDO $pdo,
    )
    {
    }

    private function preparedStatement(string $sqlQuery): PDOStatement
    {
        return $this->pdo->prepare($sqlQuery);
    }

    /** @return File[] */
    private function hydrateUsers(PDOStatement $statement): array
    {
        return array_map(function ($file) {
            return new File(
                id: $file['file_id'],
                name: $file['name'],
                fileName: $file['file_name'],
                topicId: $file['topic_id'],
            );
        }, $statement->fetchAll());
    }

    public function findAll(): array
    {
        $statement = $this->preparedStatement('SELECT * FROM files');

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findById(int $id): array
    {
        $statement = $this->preparedStatement('SELECT * FROM files WHERE file_id = :id');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findByTopicId(int $topicId): array
    {
        $statement = $this->preparedStatement('SELECT * FROM files WHERE topic_id = :id');

        $statement->bindValue(':id', $topicId, PDO::PARAM_INT);

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    private function addFile(File $file): bool
    {
        $statement = $this->preparedStatement('INSERT INTO files (name, file_name, topic_id) VALUES (:name, :file_name, :topic_id)');

        $statement->bindValue(':name', $file->name, PDO::PARAM_STR);
        $statement->bindValue(':file_name', $file->fileName, PDO::PARAM_STR);
        $statement->bindValue(':topic_id', $file->topicId, PDO::PARAM_INT);

        return $statement->execute();
    }

    private function updateFile(File $file): bool
    {
        return true;
    }

    public function save(object $object): bool
    {
        if (!$object instanceof File) {
            throw new InvalidArgumentException("Expected instance of " . File::class);
        } else {
            if ($object->id === 0) {
                return $this->addFile($object);
            } else {
                return $this->updateFile($object);
            }
        }
    }

    public function remove(int $id): bool
    {
        $statement = $this->preparedStatement('DELETE FROM files WHERE file_id = :id');

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}