<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use InvalidArgumentException;
use PDO;
use PDOStatement;
use function array_map;
use function s;
use function var_dump;

readonly class DisciplineRepository implements RepositoryInterface
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

    /** @return Discipline[] */
    private function hydrateUsers(PDOStatement $statement): array
    {
        return array_map(function ($discipline) {
            return new Discipline(
                id: $discipline['discipline_id'],
                name: $discipline['discipline_name'],
                bannerImage: $discipline['banner_image'],
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
        $statement = $this->preparedStatment("INSERT INTO disciplines (discipline_name, banner_image) VALUES (:discipline_name, :banner_image)");

        return $statement->execute([
            ':discipline_name' => $discipline->name,
            ':banner_image' => $discipline->getBannerImage()
        ]);
    }

    private function updateDiscipline(Discipline $discipline): bool
    {
        $updateBannerImageSql = "";

        if ($discipline->getBannerImage() !== null && $discipline->getBannerImage() !== "banner-teste-2.jpg") {
            $updateBannerImageSql = ", banner_image = :banner_image";
        }

        $statement = $this->preparedStatment("
            UPDATE disciplines 
            SET 
                discipline_name = :discipline_name
                $updateBannerImageSql
                WHERE 
                    discipline_id = :id
            ");

        $statement->bindValue(':discipline_name', $discipline->name, PDO::PARAM_STR);
        $statement->bindValue(':id', $discipline->id, PDO::PARAM_INT);

        if ($discipline->getBannerImage() !== null && $discipline->getBannerImage() !== "banner-teste-2.jpg") {
            $statement->bindValue(':banner_image', $discipline->getBannerImage(), PDO::PARAM_STR);
        }

        return $statement->execute();
    }

    public function updateBannerImageToNull (int $id): bool
    {
        $statement = $this->preparedStatment("UPDATE disciplines SET banner_image = null WHERE discipline_id = :id");

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function save(object $object): bool
    {
        if (!$object instanceof Discipline) {
            throw new InvalidArgumentException("Expected instance of " . Discipline::class);
        } else {
            if ($object->id === 0) {
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