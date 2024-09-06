<?php

namespace Cleitoncunha\Bird\Model\Repository;

use Cleitoncunha\Bird\Model\Entity\User;
use InvalidArgumentException;
use PDO;
use PDOStatement;

readonly class UserRepository implements RepositoryInterface
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

    /** @return User[]*/
    private function hydrateUsers(PDOStatement $statement): array
    {
        return array_map(function ($user) {
            return new User(
                id: $user['user_id'],
                username: $user['username'],
                email:  $user['user_email'],
                password:  $user['user_password'],
                level:  $user['user_level']
            );
        }, $statement->fetchAll());
    }

    public function findAll(): array
    {
        $statement = $this->preparedStatment("SELECT * FROM users");

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findById(int $id): array
    {
        $statement = $this->preparedStatment("SELECT * FROM users WHERE user_id = :id");

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function findByEmail(string $email): array
    {
        $statement = $this->preparedStatment("SELECT * FROM users WHERE user_email = :email");

        $statement->bindValue(':email', $email, PDO::PARAM_STR);

        $statement->execute();

        return $this->hydrateUsers($statement);
    }

    public function isValidEmail(string $email): bool
    {
        $statement = $this->preparedStatment("SELECT * FROM valid_emails WHERE valid_email_email = :email");

        $statement->bindValue(':email', $email);

        $statement->execute();

        return $statement->rowCount() === 1;
    }

    public function isUserAlreadyRegistered(string $email): bool
    {
        $statement = $this->preparedStatment("SELECT * FROM users WHERE user_email = :email");

        $statement->bindValue(':email', $email);

        $statement->execute();

        return $statement->rowCount() === 1;
    }

    private function addUser(User $user): bool
    {
        $statement = $this->preparedStatment("CALL insert_user(:username, :email, :password, :level)");

        $statement->bindValue(":username", $user->username);
        $statement->bindValue(":email", $user->email);
        $statement->bindValue(":password", $user->password);
        $statement->bindValue(":level", $user->level, PDO::PARAM_INT);

        return $statement->execute();
    }

    private function updateUser(User $user): bool
    {
        $statement = $this->preparedStatment("UPDATE users 
            SET 
                username = :username, 
                user_email = :user_email, 
                user_password = :user_password, 
                user_level = :user_level 
            WHERE user_id = :id"
        );

        $statement->bindValue(':username', $user->username);
        $statement->bindValue(':user_email', $user->email);
        $statement->bindValue(':user_password', $user->password);
        $statement->bindValue(':user_level', $user->level, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function save(object $object): bool
    {
        if (!$object instanceof User) {
            throw new InvalidArgumentException("Expected instance of User, got " . gettype($object));
        } else {
            if ($object->id == null) {
                return $this->addUser($object);
            } else {
                return $this->updateUser($object);
            }
        }
    }

    public function remove(int $id): bool
    {
        $statement = $this->preparedStatment("DELETE FROM users WHERE user_id = :id");

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}