<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\File;
use InvalidArgumentException;
use PDO;
use PDOStatement;
use function array_map;

readonly class FileRepositoryInterface implements RepositoryInterface
{
    public function __construct(
        private PDO $pdo,
    )
    {
    }

    private function preparedStatment(string $sqlQuery): PDOStatement
    {
        return $this->pdo->prepare($sqlQuery);
    }

    private function hydrateUsers(PDOStatement $statement): array
    {
        return array_map(function ($file) {
            return new File(
                id: $file['file_id'],
                name: $file['file_name'],

            );
        }, $statement->fetchAll());
    }

    public function findAll(): array
    {
        $statement = $this->preparedStatment('SELECT * FROM files');

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findById(int $id): array
    {
        $statement = $this->preparedStatment('SELECT * FROM files WHERE file_id = :id');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        return $this->hydrateUsers($statement);
    }

    private function addFile(): bool
    {
        $statement = $this->preparedStatment('INSERT INTO files (file_name, topic_id) VALUES (:file_name, :topic_id)');
    }

    private function updateFile(): bool
    {

    }

    public function save(object $object): bool
    {
        if (!$object instanceof File) {
            throw new InvalidArgumentException("Expected instance of " . File::class);
        } else {
            if ($object->id === null) {

            } else {

            }
        }
    }

    public function remove(int $id): bool
    {
        // TODO: Implement remove() method.
    }
}