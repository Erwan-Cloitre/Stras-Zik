<?php

namespace App\Model;

class FormManager extends AbstractManager
{
    public const TABLE = 'users';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $users
     * @return int
     */
    public function insert(array $users): int
    {
        $statement = $this->pdo->prepare("INSERT INTO users 
        (`lastname`, `firstname`, `username`, `password`, `email`, `adress`, `number`, `postal`, `city`)
        VALUES (:lastname, :firstname, :login, :password, :email, :address, :number, :postal, :city)");
        $statement->bindValue(':lastname', $users['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $users['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':login', $users['login'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $users['password'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $users['email'], \PDO::PARAM_STR);
        $statement->bindValue(':address', $users['address'], \PDO::PARAM_STR);
        $statement->bindValue(':number', $users['number'], \PDO::PARAM_INT);
        $statement->bindValue(':postal', $users['postal'], \PDO::PARAM_INT);
        $statement->bindValue(':city', $users['city'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
