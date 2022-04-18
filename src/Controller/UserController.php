<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    /**
     * Show list of comics by keywords
     */
    public function list(): string
    {
        $userManager = new UserManager();
        $comicBooks = $userManager->listByKeywords();
        var_dump($comicBooks);

        return $this->twig->render('User/list.html.twig', ['comicBooks' => $comicBooks]);
    }
}
