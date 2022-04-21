<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Service\UtilityService;

class AdminController extends AbstractController
{
    /**
     * Add a new item
     */
    public function add(): ?string
    {
        return $this->twig->render('Admin/add.html.twig');
    }

class AdminController extends AbstractController
{
    public function list(): string
    {
        $adminManager = new AdminManager();
        $comics = $adminManager->selectAll();

        return $this->twig->render('Admin/admin.html.twig', ['comics' => $comics]);
    }
}
