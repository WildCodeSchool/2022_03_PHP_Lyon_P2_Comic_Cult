<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\UserManager;
use App\Service\UtilityService;
use App\Model\ContactManager;

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
        $comicByCategory = $userManager->listByCategory();

        // Use this function to merge an array in an other one.
        $comicBooks = array_merge($comicByTitleAndPitch, $comicByAuthor, $comicByCategory);
        // Use this new method to sort comics by an attribute.
        $splitAuthorFirstName = $utilityService->sortByWords($keywords, $comicBooks, 'first_name');
        $splitAuthorLastName = $utilityService->sortByWords($keywords, $comicBooks, 'last_name');
        $splitTitle = $utilityService->sortByWords($keywords, $comicBooks, 'title');
        $splitKeywords = $utilityService->sortByWords($keywords, $comicBooks, 'keywords');
        $plitCategory = $utilityService->sortByWords($keywords, $comicBooks, 'category');
        $finalList = array_merge(
            $splitAuthorFirstName,
            $splitAuthorLastName,
            $splitTitle,
            $splitKeywords,
            $plitCategory
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
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $userMessages = array_map('trim', $_POST);

            // TODO validations (length, format...)

            if (strlen($userMessages['firstname']) > 30) {
                $errors[] = 'Le prénom renseigné ne doit pas dépasser 30 caractères.';
            }

            if (strlen($userMessages['lastname']) > 40) {
                $errors[] = 'Le nom de famille renseigné ne doit pas dépasser 40 caractères.';
            }

            if (!filter_var($userMessages['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Veuillez renseigner une adresse mail valide.';
            }

            if (empty($errors)) {
                // if validation is ok, insert and redirection
                $contactManager = new ContactManager();
                $contactManager->insert($userMessages);
            }
            return $this->twig->render('User/confirm.html.twig');
        }
        return $this->twig->render('User/contact.html.twig', ['errors' => $errors]);
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
