<?php

namespace App\Controller;

use App\Model\AdminManager;
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
        $comicByAuthor = $userManager->listByAuthor();
        $comicByCategory = $userManager->listByCategory();
        $comicByTitleAndPitch = $userManager->listByKeywords();


        // Use this function to merge an array in an other one.
        $comicBooks = array_merge($comicByAuthor, $comicByCategory, $comicByTitleAndPitch);
        // Use this new method to sort comics by an attribute.
        $splitAuthorFirstName = $utilityService->sortByWords($keywords, $comicBooks, 'first_name');
        $splitAuthorLastName = $utilityService->sortByWords($keywords, $comicBooks, 'last_name');
        $plitCategory = $utilityService->sortByWords($keywords, $comicBooks, 'category');
        $splitTitle = $utilityService->sortByWords($keywords, $comicBooks, 'title');
        $splitKeywords = $utilityService->sortByWords($keywords, $comicBooks, 'keywords');
        $finalList = array_merge(
            $splitAuthorLastName,
            $splitAuthorFirstName,
            $plitCategory,
            $splitTitle,
            $splitKeywords
        );
        // Use this method to delete duplicates (for ex: One comic may have 2 or 3 authors).
        $finalList = $utilityService->arrayUnique($finalList, 'title');
        return $this->twig->render('User/list.html.twig', ['comicBooks' => $finalList]);
    }

    /**
     * Add a new message
     */
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $userMessages = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $userMessageManager = new UserManager();
            $userMessageManager->insert($userMessages);
        }
        return $this->twig->render('User/contact.html.twig');
    }

    public function details($id): string
    {
        $adminManager = new AdminManager();
        $comics = $adminManager->selectOneById($id);
        $comicsAuthor = $adminManager->selectAllAuthorsInJunction();
        return $this->twig->render('User/details.html.twig', array(
            'comics' => $comics,
            'comicAuthors' => $comicsAuthor
        ));
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $credentials = array_map('trim', $_POST);
            //      @todo make some controls on email and password fields and if errors, send them to the view
            $userManager = new UserManager();
            $user = $userManager->selectOneByUser($credentials['user_name']);
            if ($user && ($credentials['password'] === $user['password'])) {
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
