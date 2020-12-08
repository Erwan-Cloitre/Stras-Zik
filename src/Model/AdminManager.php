<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'users';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function login(array $login)
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE username=:username AND password=:password"
        );
        $statement->bindValue('username', $login['username'], \PDO::PARAM_STR);
        $statement->bindValue('password', $login['password'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
