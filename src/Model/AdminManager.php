<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'comic_book';
    public const TABLE2 = 'comic_book_author';

    /**
     * Delete comic book from database
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE2 . " WHERE comic_book_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Insert new comic book in database
     */
    public function insert(array $comicBook): void
    {
        $query = 'INSERT INTO comic_book (`title`, `title_keywords`, `isbn`, `date_of_release`,
                    `pitch`, `keywords`, `nb_pages`, `volume`, `price`,
                    `cover`, `author_name`, `category_id`)
                    VALUES (:title, :title_keywords, :isbn, :date_of_release, :pitch, :keywords, :nb_pages,
                    :volume, :price, :cover, :author_name, :category_id)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $comicBook['title'], \PDO::PARAM_STR);
        $statement->bindValue(':title_keywords', $comicBook['title_keywords'], \PDO::PARAM_STR);
        $statement->bindValue(':isbn', $comicBook['isbn'], \PDO::PARAM_INT);
        $statement->bindValue(':date_of_release', $comicBook['date_of_release'], \PDO::PARAM_STR);
        $statement->bindValue(':pitch', $comicBook['pitch'], \PDO::PARAM_STR);
        $statement->bindValue(':keywords', $comicBook['keywords'], \PDO::PARAM_STR);
        $statement->bindValue(':nb_pages', $comicBook['nb_pages'], \PDO::PARAM_INT);
        $statement->bindValue(':volume', $comicBook['volume'], \PDO::PARAM_INT);
        $statement->bindValue(':price', $comicBook['price'], \PDO::PARAM_STR);
        $statement->bindValue(':cover', $comicBook['cover'], \PDO::PARAM_STR);
        $statement->bindValue(':author_name', $comicBook['author_name'], \PDO::PARAM_STR);
        $statement->bindValue(':category_id', $comicBook['category_id'], \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Get one comic from database by ID.
     */
    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM comic_book
                                            INNER JOIN category ON category.id=comic_book.category_id
                                            WHERE comic_book.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Update one comic from database by Id.
     */
    public function update(array $comicBook, int $id): void
    {
        $query = 'UPDATE comic_book SET `title`=:title, `title_keywords`=:title_keywords, `isbn`=:isbn,
                    `date_of_release`=:date_of_release, `pitch`=:pitch, `keywords`=:keywords,
                    `nb_pages`=:nb_pages, `volume`=:volume, `price`=:price, `cover`=:cover,
                    `author_name`=:author_name, `category_id`=:category_id
                    WHERE `id`=:id;';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':title', $comicBook['title'], \PDO::PARAM_STR);
        $statement->bindValue(':title_keywords', $comicBook['title_keywords'], \PDO::PARAM_STR);
        $statement->bindValue(':isbn', $comicBook['isbn'], \PDO::PARAM_INT);
        $statement->bindValue(':date_of_release', $comicBook['date_of_release'], \PDO::PARAM_STR);
        $statement->bindValue(':pitch', $comicBook['pitch'], \PDO::PARAM_STR);
        $statement->bindValue(':keywords', $comicBook['keywords'], \PDO::PARAM_STR);
        $statement->bindValue(':nb_pages', $comicBook['nb_pages'], \PDO::PARAM_INT);
        $statement->bindValue(':volume', $comicBook['volume'], \PDO::PARAM_INT);
        $statement->bindValue(':price', $comicBook['price'], \PDO::PARAM_STR);
        $statement->bindValue(':cover', $comicBook['cover'], \PDO::PARAM_STR);
        $statement->bindValue(':author_name', $comicBook['author_name'], \PDO::PARAM_STR);
        $statement->bindValue(':category_id', $comicBook['category_id'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
