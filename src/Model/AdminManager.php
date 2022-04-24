<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'comic_book';

    /**
     * Get all authors from database.
     */
    public function selectAllAuthors(): array
    {
        $query = 'SELECT * FROM `author`
                    left JOIN `role_author` ON `role_author`.`author_id`=`author`.`id`
                    left JOIN `role` ON `role`.`id`=`role_author`.`role_id`;';

        return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
