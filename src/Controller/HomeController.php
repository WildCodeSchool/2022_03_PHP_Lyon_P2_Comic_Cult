<?php

namespace App\Controller;

use App\Model\HomeManager;

class HomeController extends AbstractController
{
    /**
     * Display home page and send keywords to Database
     */
    public function index(): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keywords = trim($_POST['keywords']);
            $keywords = preg_replace('/\s\s+/', ' ', $keywords);
            $keywords = explode(' ', $keywords);

            foreach ($keywords as $keyword) {
                if (empty($keyword)) {
                    $errors[] = "Merci de renseigner au minimum un mot dans le champ de recherche.";
                }
                if (strlen($keyword) > 80) {
                    $errors[] = "Un des mots-clés utilisé est trop long. Longueur maximale autorisée : 80 caractères.";
                }
            }
            if (empty($errors)) {
                $homeManager = new HomeManager();
                $homeManager->sendToDatabase($keywords);
                header('Location: search');
            }
        }
        return $this->twig->render('Home/index.html.twig', ['errors' => $errors]);
    }
}
