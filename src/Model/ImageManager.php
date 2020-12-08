<?php

namespace App\Model;

class ImageManager extends AbstractManager
{
    public const TABLE = 'image';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $img): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`parent_id`, `parent_type`, `img_path`) 
            VALUES (:parent_id, :parent_type, :img_path)"
        );
        $statement->bindValue('parent_id', $img['parent_id'], \PDO::PARAM_INT);
        $statement->bindValue('parent_type', $img['parent_type'], \PDO::PARAM_STR);
        $statement->bindValue('img_path', $img['img_path'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $img): bool
    {

        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `parent_id` = :parent_id, `parent_type` = :parent_type, `img_path` = :img_path
         WHERE id=:id"
        );
        $statement->bindValue('parent_id', $img['parent_id'], \PDO::PARAM_INT);
        $statement->bindValue('parent_type', $img['parent_type'], \PDO::PARAM_STR);
        $statement->bindValue('img_path', $img['img_path'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function getOneByParentIdAndType($parentId, $type)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM $this->table WHERE parent_id=:parent_id AND parent_type=:parent_type"
        );
        $statement->bindValue('parent_id', $parentId, \PDO::PARAM_INT);
        $statement->bindValue('parent_type', $type, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
