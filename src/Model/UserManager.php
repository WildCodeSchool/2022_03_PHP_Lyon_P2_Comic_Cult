<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'comic_book';


    /**
     * Select results by title and description
     */
    public function listByKeywords(): array
    {
        $query = 'SELECT DISTINCT * FROM comic_book
                    INNER JOIN keywords_search
                    WHERE INSTR(comic_book.title, keywords_search.keyword)
                    OR INSTR(comic_book.pitch, keywords_search.keyword);';
        $statement = $this->pdo->query($query);
        $comicBooks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $comicBooks;
    }
}
