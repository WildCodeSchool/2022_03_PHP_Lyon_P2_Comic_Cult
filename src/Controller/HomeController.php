<?php

namespace App\Controller;

use App\Model\HomeManager;
use App\Model\UserManager;
use App\Service\UtilityService;

class HomeController extends AbstractController
{
    /**
     * Display home page and send keywords to Database
     */
    public function index(): string
    {
        $utilityService = new UtilityService();
        $userManager = new UserManager();
        $completionList = $userManager->selectTwentyLastCompletions();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keywordsString = $keywords = trim($_POST['keywords']);
            $keywords = $utilityService->clearString($keywords);
            $keywords = trim($keywords);
            // fonction used to clear all spaces between words.
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
            if (strlen($keywordsString) > 255) {
                $errors[] = "Votre recherche ne doit pas dépasser 255 caractères.";
            }

            if (empty($errors)) {
                $homeManager = new HomeManager();
                $homeManager->sendToDatabase($keywords);
                $homeManager->sendCompletion($keywordsString);
                header('Location: search');
            }
        }
        return $this->twig->render('Home/index.html.twig', array('errors' => $errors,
                                                                    'completionList' => $completionList));
    }
}
