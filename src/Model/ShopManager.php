<?php

namespace App\Model;

class ShopManager extends AbstractManager
{
    public const TABLE = 'shop';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function getByIds($productIds)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE `id` IN (" . implode(", ", $productIds) . ")"
        );
        $productIdsString = implode(', ', $productIds);
        $statement->bindValue('productIds', $productIdsString, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function insert(array $product): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`title` ,`description` ,`price`)
            VALUES (:title, :description, :price)"
        );
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);


        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $product): bool
    {

        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `title` = :title,`description` = :description,`price` = :price
         WHERE id=:id"
        );
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('id', $product['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
