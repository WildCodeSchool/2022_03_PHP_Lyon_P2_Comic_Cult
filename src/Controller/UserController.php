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
        $utilityService = new UtilityService();
        $keywords = $userManager->keywordsList();
        $comicByTitleAndPitch = $userManager->listByKeywords();
        $comicByAuthor = $userManager->listByAuthor();
        $comicBooks = array_merge($comicByTitleAndPitch, $comicByAuthor);
        $splitTitle = [];
        $splitKeywords = [];
        $finalList = [];

        foreach ($keywords as $keyword) {
                $keyword['keyword'] = strtolower($keyword['keyword']);
            foreach ($comicBooks as $comicBook) {
                $comicTitle = $utilityService->clearString($comicBook['title']);
                $comicTitle = preg_replace('/\s\s+/', ' ', $comicTitle);
                $splitTitle = explode(" ", $comicTitle);
                $comicKeywords = $utilityService->clearString($comicBook['keywords']);
                $comicKeywords = preg_replace('/\s\s+/', ' ', $comicKeywords);
                $splitKeywords = explode(" ", $comicKeywords);
                foreach ($splitTitle as $word) {
                    if (strcmp($word, $keyword['keyword']) == 0) {
                        $finalList[] = $comicBook;
                    }
                }
                foreach ($splitKeywords as $word) {
                    if (strcmp($word, $keyword['keyword']) == 0) {
                        $finalList[] = $comicBook;
                    }
                }
            }
        }
        $finalList = array_unique($finalList, SORT_REGULAR);
        return $this->twig->render('User/list.html.twig', ['comicBooks' => $finalList]);
    }
}
