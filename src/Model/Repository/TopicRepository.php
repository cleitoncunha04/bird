<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use InvalidArgumentException;
use PDO;
use PDOStatement;
use function array_map;

readonly class TopicRepository implements RepositoryInterface
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
        return array_map(function ($topic) {
            return new Discipline(
                id: $topic['topic_id'],
                name: $topic['topic_name']
            );
        }, $statement->fetchAll());
    }

    public function findAll(): array
    {
        $statement = $this->preparedStatment('SELECT * FROM topics');

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findById(int $id): array
    {
        $statement = $this->preparedStatment('SELECT * FROM topics WHERE topic_id = :id');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    private function addTopic(Topic $topic): bool
    {
        $statement = $this->preparedStatment("INSERT INTO topics (topic_name) VALUES (:topic_name)");

        return $statement->execute([
            ':topic_name' => $topic->name
        ]);
    }

    private function updateTopic(Topic $topic): bool
    {
        $statement = $this->preparedStatment("UPDATE topics SET topic_name = :topic_name WHERE topic_id = :id");

        return $statement->execute([
            ':topic_name' => $topic->name,
        ]);
    }

    public function save(object $object): bool
    {
        if (!$object instanceof Topic) {
            throw new InvalidArgumentException('$object must be an instance of Topic');
        } else {
            if ($object->id === null) {
                return $this->addTopic($object);
            } else {
                return $this->updateTopic($object);
            }
        }
    }

    public function remove(int $id): bool
    {
        $statement = $this->preparedStatment("DELETE FROM topics WHERE topic_id = :id");

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}