<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Service\UtilityService;

class UserController extends AbstractController
{
    /**
     * Show list of comics sorted by title and description
     */
    public function list(): string
    {
        $userManager = new UserManager();
        $keywords = $userManager->keywordsList();
        $comicBooks = $userManager->listByKeywords();
        $splitTitle = [];
        $splitPitch = [];
        $finalList = [];
        $characterToReplace = ['\'', '"', ',', '-', '.', ':', ';', '?', '!'];

        foreach ($keywords as $keyword) {
                $keyword['keyword'] = strtolower($keyword['keyword']);
            foreach ($comicBooks as $comicBook) {
                // $splitTitle = [];
                $comicTitle = str_replace($characterToReplace, ' ', $comicBook['title']);
                $comicTitle = strtolower($comicTitle);
                $splitTitle = explode(" ", $comicTitle);
                $comicPitch = str_replace($characterToReplace, ' ', $comicBook['pitch']);
                $comicPitch = strtolower($comicPitch);
                $splitPitch = explode(" ", $comicPitch);
                foreach ($splitTitle as $word) {
                    if (strcmp($word, $keyword['keyword']) == 0) {
                        $finalList[] = $comicBook;
                    }
                }
                foreach ($splitPitch as $word) {
                    if (strcmp($word, $keyword['keyword']) == 0) {
                        $finalList[] = $comicBook;
                    }
                }
            }
        }
        $finalList = array_unique($finalList, SORT_REGULAR);
        var_dump($finalList);
        return $this->twig->render('User/list.html.twig', ['comicBooks' => $finalList]);
    }
}
