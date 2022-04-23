<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'comic_book';

    /**
     * Insert new comic book in database
     */
    public function insert(array $comicBook): void
    {
        $query = 'INSERT INTO comic_book (`title`, `isbn`, `date_of_release`,
                    `pitch`, `keywords`, `nb_pages`, `volume`, `price`,
                    `cover`, `author_name`, `category_id`)
                    VALUES (:title, :isbn, :date_of_release, :pitch, :keywords, :nb_pages,
                    :volume, :price, :cover, :author_name, :category_id)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $comicBook['title'], \PDO::PARAM_STR);
        $statement->bindValue(':isbn', $comicBook['isbn'], \PDO::PARAM_INT);
        $statement->bindValue(':date_of_release', $comicBook['date_of_release'], \PDO::PARAM_STR);
        $statement->bindValue(':pitch', $comicBook['pitch'], \PDO::PARAM_STR);
        $statement->bindValue(':keywords', $comicBook['keywords'], \PDO::PARAM_STR);
        $statement->bindValue(':nb_pages', $comicBook['nb_pages'], \PDO::PARAM_INT);
        $statement->bindValue(':volume', $comicBook['volume'], \PDO::PARAM_STR);
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
}
