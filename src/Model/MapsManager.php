<?php

namespace App\Model;

class MapsManager extends AbstractManager
{
    public const TABLE = 'map';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $maps): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE . " (`url`) VALUES (:url)"
        );
        $statement->bindValue('url', $maps['url'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $maps): bool
    {

        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `url` = :url
         WHERE id=:id"
        );
        $statement->bindValue('url', $maps['url'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
