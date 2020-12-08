<?php

namespace App\Model;

class DiscoManager extends AbstractManager
{
    public const TABLE = 'album';


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

    public function insert(array $disk): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`name` ,`url`) 
            VALUES (:name, :url)"
        );
        $statement->bindValue('name', $disk['name'], \PDO::PARAM_STR);
        $statement->bindValue('url', $disk['url'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $disk): bool
    {

        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `name` = :name,`url` = :url
         WHERE id=:id"
        );
        $statement->bindValue('name', $disk['name'], \PDO::PARAM_STR);
        $statement->bindValue('url', $disk['url'], \PDO::PARAM_STR);
        $statement->bindValue('id', $disk['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
