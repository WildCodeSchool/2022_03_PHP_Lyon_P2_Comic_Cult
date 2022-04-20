<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'comic_book';
    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
