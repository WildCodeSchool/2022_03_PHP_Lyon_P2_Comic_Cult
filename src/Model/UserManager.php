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
        $query = 'SELECT DISTINCT comic_book.*, author.first_name, author.first_name_keyword,
                    author.last_name, author.last_name_keyword, author.editor FROM comic_book
                    INNER JOIN keywords_search
                    LEFT JOIN comic_book_author ON comic_book_author.comic_book_id=comic_book.id
                    LEFT JOIN author ON author.id=comic_book_author.author_id
                    WHERE INSTR(comic_book.title_keywords, keywords_search.keyword)
                    OR INSTR(comic_book.keywords, keywords_search.keyword);';
        $statement = $this->pdo->query($query);
        $comicBooks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $comicBooks;
    }

    /**
     * Select results by author
     */
    public function listByAuthor(): array
    {
        $query = 'SELECT DISTINCT comic_book.*, author.first_name, author.first_name_keyword,
                    author.last_name, author.last_name_keyword, author.editor FROM comic_book
                    INNER JOIN keywords_search
                    LEFT JOIN comic_book_author ON comic_book_author.comic_book_id=comic_book.id
                    LEFT JOIN author ON author.id=comic_book_author.author_id
                    WHERE INSTR(author.first_name_keyword, keywords_search.keyword)
                    OR INSTR(author.last_name_keyword, keywords_search.keyword);';
        $statement = $this->pdo->query($query);
        $comicBooks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $comicBooks;
    }
}
