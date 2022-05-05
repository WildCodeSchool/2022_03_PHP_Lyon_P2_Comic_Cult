<?php

namespace App\Model;

class HomeManager extends AbstractManager
{
    public const TABLE = 'comic_book';


    /**
     * Send keywords to database
     */
    public function sendToDatabase(array $keywords): void
    {
        $truncateQuery = 'TRUNCATE TABLE `keywords_search`;';
        $firstStatement = $this->pdo->query($truncateQuery);
        $firstStatement->execute();

        foreach ($keywords as $keyword) {
            $addQuery = 'INSERT INTO `keywords_search` VALUES (:keyword);';
            $secondStatement = $this->pdo->prepare($addQuery);
            $secondStatement->bindValue(':keyword', $keyword, \PDO::PARAM_STR);
            $secondStatement->execute();
        }
    }

    public function sendCompletion(string $keywordsString): void
    {
        $query = 'INSERT INTO `auto_completion` (string) VALUES (:keywordsString);';
        $secondStatement = $this->pdo->prepare($query);
        $secondStatement->bindValue(':keywordsString', $keywordsString, \PDO::PARAM_STR);
        $secondStatement->execute();
    }
}
