<?php


namespace App\Model;


class SubscriberManager extends AbstractManager
{
    const TABLE = 'subscriber';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $subscriber
     * @return int
     */
    public function insert(array $subscriber): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            "(lastname, firstname, email) VALUES (:lastname, :firstname, :email)");
        $statement->bindValue(':lastname', $subscriber['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $subscriber['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $subscriber['email'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
