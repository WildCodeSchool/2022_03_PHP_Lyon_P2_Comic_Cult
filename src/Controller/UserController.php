<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Service\UtilityService;

class UserController extends AbstractController
{
    /**
     * Show list of comics sorted by title, description or author
     */
    public function list(): string
    {
        $userManager = new UserManager();
        $utilityService = new UtilityService();
        $keywords = $userManager->keywordsList();
        $comicByTitleAndPitch = $userManager->listByKeywords();
        $comicByAuthor = $userManager->listByAuthor();

        // Use this function to merge an array in an other one.
        $comicBooks = array_merge($comicByTitleAndPitch, $comicByAuthor);

        // Use this new method to sort comics by an attribute.
        $splitAuthorFirstName = $utilityService->sortByWords($keywords, $comicBooks, 'first_name');
        $splitAuthorLastName = $utilityService->sortByWords($keywords, $comicBooks, 'last_name');
        $splitTitle = $utilityService->sortByWords($keywords, $comicBooks, 'title');
        $splitKeywords = $utilityService->sortByWords($keywords, $comicBooks, 'keywords');

        $finalList = array_merge($splitAuthorFirstName, $splitAuthorLastName, $splitTitle, $splitKeywords);

        // Use this method to delete duplicates (for ex: One comic may have 2 or 3 authors).
        $finalList = $utilityService->arrayUnique($finalList, 'title');

        return $this->twig->render('User/list.html.twig', ['comicBooks' => $finalList]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new UserManager();
            $user = $userManager->selectOneByUser($credentials['user_name']);
            if ($credentials['password'] === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: admin/list');
            }
        }
        return $this->twig->render('Home/index.html.twig');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
    }
}
