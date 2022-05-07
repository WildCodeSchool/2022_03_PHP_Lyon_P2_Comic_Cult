<?php

namespace App\Controller;

use App\Model\AdminManager;

class DetailController extends AbstractController
{
    public function details($id): string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $adminManager = new AdminManager();
        $comics = $adminManager->selectOneById($id);
        $authors = $adminManager-> selectAuthorInJunctionById($id);
        return $this->twig->render('Admin/details.html.twig', array(
            'comics' => $comics,
            'authors' => $authors
        ));
    }
}
