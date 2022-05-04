<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';
    public const CONTACT_TABLE = 'contact';

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
                    author.last_name, author.last_name_keyword, author.editor,
                    category.category, category.category_keyword FROM comic_book
                    INNER JOIN keywords_search
                    LEFT JOIN comic_book_author ON comic_book_author.comic_book_id=comic_book.id
                    LEFT JOIN author ON author.id=comic_book_author.author_id
                    LEFT JOIN category ON category.id=comic_book.category_id
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
                    author.last_name, author.last_name_keyword, author.editor,
                    category.category, category.category_keyword FROM comic_book
                    INNER JOIN keywords_search
                    LEFT JOIN comic_book_author ON comic_book_author.comic_book_id=comic_book.id
                    LEFT JOIN author ON author.id=comic_book_author.author_id
                    LEFT JOIN category ON category.id=comic_book.category_id
                    WHERE INSTR(author.first_name_keyword, keywords_search.keyword)
                    OR INSTR(author.last_name_keyword, keywords_search.keyword);';
        $statement = $this->pdo->query($query);
        $comicBooks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $comicBooks;
    }

    public function selectOneByUser(string $user)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE user_name=:user_name");
        $statement->bindValue('user_name', $user, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert new message in database
     */
    public function insert(array $userMessages): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::CONTACT_TABLE . " (firstname, lastname, email, message)
        VALUES (:firstname, :lastname, :email, :message)");
        $statement->bindValue('firstname', $userMessages['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $userMessages['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $userMessages['email'], \PDO::PARAM_STR);
        $statement->bindValue('message', $userMessages['message'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function listByCategory(): array
    {
        $query = 'SELECT DISTINCT comic_book.*, author.first_name, author.first_name_keyword,
                    author.last_name, author.last_name_keyword, author.editor,
                    category.category, category.category_keyword FROM comic_book
                    INNER JOIN keywords_search
                    LEFT JOIN comic_book_author ON comic_book_author.comic_book_id=comic_book.id
                    LEFT JOIN author ON author.id=comic_book_author.author_id
                    LEFT JOIN category ON category.id=comic_book.category_id
                    WHERE INSTR(category.category_keyword, keywords_search.keyword)';
        $statement = $this->pdo->query($query);
        $comicBooks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $comicBooks;
    }
}
