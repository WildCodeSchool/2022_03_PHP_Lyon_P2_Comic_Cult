<?php

namespace App\Controller;
use App\Model\AdminManager;

class AdminController extends AbstractController
{
    
    /**
     * Comics list
     */
    public function list(): string
    {
        $adminManager = new AdminManager();
        $comics = $adminManager->selectAll();

        return $this->twig->render('Admin/admin.html.twig', ['comics' => $comics]);
    }
}
