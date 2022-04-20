<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'comic_book';


    /**
     * list of user's keywords sent from home page.
     */
    public function keywordsList(): array
    {
        $query = 'SELECT * FROM `keywords_search`';
        $statement = $this->pdo->query($query);
        $keywords = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $keywords;
    }

    /**
     * Select results by title and description
     */
    public function listByKeywords(): array
    {
        $query = 'SELECT DISTINCT comic_book.* FROM comic_book
                    INNER JOIN keywords_search
                    WHERE INSTR(comic_book.title, keywords_search.keyword)
                    OR INSTR(comic_book.keywords, keywords_search.keyword);';
        $statement = $this->pdo->query($query);
        $comicBooks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $comicBooks;
    }
}
