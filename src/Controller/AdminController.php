<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Service\UtilityService;

class AdminController extends AbstractController
{
    public function list(): string
    {
        $adminManager = new AdminManager();
        $comics = $adminManager->selectAll();

        return $this->twig->render('Admin/admin.html.twig', ['comics' => $comics]);
    }

    public function add(): ?string
    {
        return $this->twig->render('Admin/add.html.twig');
    }

    public function authorList(): string
    {
        $adminManager = new AdminManager();
        $authors = $adminManager->selectAllAuthors();
        //var_dump($authors);
        //die();

        return $this->twig->render('Admin/author.html.twig', ['authors' => $authors]);
    }
}
