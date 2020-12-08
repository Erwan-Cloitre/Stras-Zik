<?php

namespace App\Model;

class NewsManager extends AbstractManager
{

    /**
     *
     */
    public const TABLE = 'news';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function insert(array $new): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (title, description) VALUES (:title, :description)"
        );
        $statement->bindValue('title', $new['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $new['description'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $new): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
                    " SET `title` = :title,`description` = :description
                    WHERE id=:id"
        );
        $statement->bindValue('title', $new['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $new['description'], \PDO::PARAM_STR);
        $statement->bindValue('id', $new['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
