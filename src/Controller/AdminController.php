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
}
