<?php

namespace App\Model;

class ContactManager extends AbstractManager
{
    public const TABLE = 'contact';

    /**
     * Insert new message in database
     */
    public function insert(array $userMessages): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (firstname, lastname, email, message)
        VALUES (:firstname, :lastname, :email, :message)");
        $statement->bindValue('firstname', $userMessages['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $userMessages['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $userMessages['email'], \PDO::PARAM_STR);
        $statement->bindValue('message', $userMessages['message'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
