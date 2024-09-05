<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use InvalidArgumentException;
use PDO;
use PDOStatement;
use function array_map;

readonly class DisciplineRepositoryInterface implements RepositoryInterface
{
    public function __construct(
        private PDO $pdo
    )
    {
    }

    private function preparedStatment(string $sqlQuery): PDOStatement
    {
        return $this->pdo->prepare($sqlQuery);
    }

    private function hydrateUsers(PDOStatement $statement): array
    {
        return array_map(function ($discipline) {
            return new Discipline(
                id: $discipline['discipline_id'],
                name: $discipline['discipline_name']
            );
        }, $statement->fetchAll());
    }

    public function findAll(): array
    {
        $statement = $this->preparedStatment("SELECT * FROM disciplines");

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findById(int $id): array
    {
        $statement = $this->preparedStatment("SELECT * FROM disciplines WHERE discipline_id = :id");

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    private function addDiscipline(Discipline $discipline): bool
    {
        $statement = $this->preparedStatment("INSERT INTO disciplines (discipline_name) VALUES (:discipline_name)");

        return $statement->execute([
            ':discipline_name' => $discipline->id
        ]);
    }

    private function updateDiscipline(Discipline $discipline): bool
    {
        $statement = $this->preparedStatment("UPDATE disciplines SET discipline_name = :discipline_name WHERE discipline_id = :id");

        return $statement->execute([
            ':discipline_name' => $discipline->id
        ]);
    }

    public function save(object $object): bool
    {
        if (!$object instanceof Discipline) {
            throw new InvalidArgumentException("Expected instance of " . Discipline::class);
        } else {
            if ($object->id === null) {
                return $this->addDiscipline($object);
            } else {
                return $this->updateDiscipline($object);
            }
        }
    }

    public function remove(int $id): bool
    {
        $statement = $this->preparedStatment("DELETE FROM disciplines WHERE discipline_id = :id");

        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}