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
     * Get all authors from database.
     */
    public function selectAllAuthors(): array
    {
        $query = 'SELECT * FROM `author`
                    /*left JOIN `role_author` ON `role_author`.`author_id`=`author`.`id`
                    left JOIN `role` ON `role`.`id`=`role_author`.`role_id`*/;';

        return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectAllGenre(): array
    {
        $query = 'SELECT * FROM category';

        return $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
