<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'comic_book';

    /**
     * Insert new item in database
     */
    public function insert(array $item): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
