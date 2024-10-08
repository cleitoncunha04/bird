<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use Cleitoncunha\Bird\Model\Entity\Topic;
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

    /** @return Topic[] */
    private function hydrateUsers(PDOStatement $statement): array
    {
        return array_map(function ($topic) {
            return new Topic(
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

    public function findByName(string $name): array
    {
        $statement = $this->preparedStatment('SELECT * FROM topics WHERE topic_name = :name');

        $statement->execute([':name' => $name]);

        return $this->hydrateUsers($statement);
    }

    public function addTopicInDiscipline(int $topicId, int $disciplineId): bool
    {
        $statement = $this->preparedStatment("INSERT INTO disciplines_has_topics (discipline_id, topic_id) VALUES (:discipline_id, :topic_id)");

        $statement->bindValue(':discipline_id', $disciplineId, PDO::PARAM_INT);
        $statement->bindValue(':topic_id', $topicId, PDO::PARAM_INT);

        return $statement->execute();
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

        $statement->bindValue(':topic_name', $topic->name, PDO::PARAM_STR);
        $statement->bindValue(':id', $topic->id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function save(object $object): bool
    {
        if (!$object instanceof Topic) {
            throw new InvalidArgumentException('$object must be an instance of Topic');
        } else {
            if ($object->id === 0) {
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