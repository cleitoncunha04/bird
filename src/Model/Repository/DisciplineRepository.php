<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\Discipline;
use Cleitoncunha\Bird\Model\Entity\File;
use Cleitoncunha\Bird\Model\Entity\Topic;
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

    /** @return Discipline[] */
    public function findDisciplinesWithTopics(): array
    {
        $statement = $this->preparedStatment("
        SELECT 
            d.discipline_id, 
            d.discipline_name, 
            d.banner_image,
            t.topic_id, 
            t.topic_name
        FROM 
            bird.disciplines d
        INNER JOIN 
            bird.disciplines_has_topics dht ON d.discipline_id = dht.discipline_id
        INNER JOIN 
            bird.topics t ON dht.topic_id = t.topic_id;
    ");

        $statement->execute();

        $disciplines = [];

        foreach ($statement->fetchAll() as $disciplineWithTopicsData) {
            // Verifica se a disciplina já existe no array
            if (!array_key_exists($disciplineWithTopicsData['discipline_id'], $disciplines)) {
                // Cria uma nova disciplina se ela ainda não existir
                $disciplines[$disciplineWithTopicsData['discipline_id']] = new Discipline(
                    id: $disciplineWithTopicsData['discipline_id'],
                    name: $disciplineWithTopicsData['discipline_name'],
                    bannerImage: $disciplineWithTopicsData['banner_image'],
                );
            }

            // Cria o tópico e adiciona à disciplina
            $topic = new Topic(
                id: $disciplineWithTopicsData['topic_id'],
                name: $disciplineWithTopicsData['topic_name'],
            );

            $statement = $this->preparedStatment("SELECT * FROM files WHERE topic_id = :id");

            $statement->bindValue(':id', $topic->id, PDO::PARAM_INT);

            $statement->execute();

            foreach ($statement->fetchAll() as $fileData) {
                $file = new File(
                    id: $fileData['file_id'],
                    name: $fileData['name'],
                    fileName: $fileData['file_name'],
                    topicId: $fileData['topic_id'],
                );

                $topic->addFiles($file);
            }

            // Adiciona o tópico à disciplina
            $disciplines[$disciplineWithTopicsData['discipline_id']]->addTopics($topic);
        }

        return $disciplines;
    }

    public function findByName(string $name): array
    {
        $statement = $this->preparedStatment("SELECT * FROM disciplines WHERE discipline_name = :name");

        $statement->bindValue(':name', $name, PDO::PARAM_STR);

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