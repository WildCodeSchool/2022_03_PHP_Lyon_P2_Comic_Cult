<?php

namespace App\Model;

use Exception;

class AuthorManager extends AbstractManager
{
    public const TABLE = 'author';


    public function deleteAuthor(int $authorId)
    {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE id=:id;';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $authorId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
