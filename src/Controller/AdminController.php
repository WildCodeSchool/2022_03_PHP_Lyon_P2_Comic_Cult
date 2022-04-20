<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    /**
     * Display home page
     */
    public function list(): string
    {
        return $this->twig->render('Admin/admin.html.twig');
    }
}