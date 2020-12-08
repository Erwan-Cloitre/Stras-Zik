<?php

namespace App\Model;

class EventManager extends AbstractManager
{

    public const TABLE = 'agenda';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllEvents(): array
    {
        return $this->pdo->query('SELECT * FROM agenda ORDER BY booking_date ASC')->fetchAll();
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function insert(array $event): int
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`title` ,`booking_date`, `location`, `number_seat`) 
            VALUES (:title, :booking_date, :location, :number_seat)"
        );
        $statement->bindValue('title', $event['title'], \PDO::PARAM_STR);
        $statement->bindValue('booking_date', $event['date'], \PDO::PARAM_STR);
        $statement->bindValue('location', $event['location'], \PDO::PARAM_STR);
        $statement->bindValue('number_seat', $event['number_seat'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update(array $event): bool
    {

        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET `title` = :title,`location` = :location,`booking_date` = :booking_date,`number_seat` = :number_seat
         WHERE id=:id"
        );
        $statement->bindValue('title', $event['title'], \PDO::PARAM_STR);
        $statement->bindValue('booking_date', $event['date'], \PDO::PARAM_STR);
        $statement->bindValue('location', $event['location'], \PDO::PARAM_STR);
        $statement->bindValue('number_seat', $event['number_seat'], \PDO::PARAM_INT);
        $statement->bindValue('id', $event['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
