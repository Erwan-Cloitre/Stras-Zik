<?php

namespace App\Model;

class VideoManager extends AbstractManager
{
    public const TABLE = 'video';


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

    public function insert(array $video): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`title` ,`url`) 
            VALUES (:title, :url)"
        );
        $statement->bindValue('title', $video['title'], \PDO::PARAM_STR);
        $statement->bindValue('url', $video['url'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $video): bool
    {

        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `title` = :title,`url` = :url
         WHERE id=:id"
        );
        $statement->bindValue('title', $video['title'], \PDO::PARAM_STR);
        $statement->bindValue('url', $video['url'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
