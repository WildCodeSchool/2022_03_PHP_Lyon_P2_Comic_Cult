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
        $cleanComicBook = new UtilityService();

        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $errors = [];
            $comicBook = array_map('trim', $_POST);
            // Three function in UtilityService to clean comic book's datas.
            $errors[] = $cleanComicBook->comicBookEmptyVerify($comicBook);
            $errors[] = $cleanComicBook->comicBookNumberValidate($comicBook);
            $errors[] = $cleanComicBook->comicBookStringVerify($comicBook);
            $comicBook['keywords'] = $cleanComicBook->clearString($comicBook['pitch']);

            $uploadDir = 'assets/images/comicUpload/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['cover']['name']);
            $comicBook['cover'] = $uploadFile;
            // Function to verify integrity of uploaded file.
            $errors[] = $cleanComicBook->coverIntegrityVerify($_FILES);
            var_dump($errors);

            /*
            if (empty($errors)) {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
            }*/

            /*
            $uploadDir = 'assets/images/comicUpload/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['cover']['name']);
            $comicBook['cover'] = $uploadFile;
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg','jpeg','png'];
            $maxFileSize = 2000000;

            if ((!in_array($extension, $authorizedExtensions))){
                $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
            }
            if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
            $errors[] = "Votre fichier doit faire moins de 2M !";
            }
            */

            //var_dump($comicBook);
            /*
            if (empty($comicBook['title'])) {
                $errors[] = 'Les champs munis d\'un "*" sont obligatoires.';
            }
            if (empty($comicBook['date_of_release'])) {
                $errors[] = 'Les champs munis d\'un "*" sont obligatoires.';
            }
            if (empty($comicBook['category'])) {
                $errors[] = 'Les champs munis d\'un "*" sont obligatoires.';
            }
            if (empty($comicBook['author_name'])) {
                $errors[] = 'Les champs munis d\'un "*" sont obligatoires.';
            }
            if (empty($comicBook['pitch'])) {
                $errors[] = 'Les champs munis d\'un "*" sont obligatoires.';
            }*/
            /*
            if (
                empty($comicBook['title']) || empty($comicBook['date_of_release']) ||
                empty($comicBook['category']) || empty($comicBook['author_name'])  ||
                empty($comicBook['pitch'])
                ) {
                    $errors[] = 'Les champs munis d\'un "*" sont obligatoires.';
                }*/
            /*
            if ($comicBook['title'] > 255) {
                $errors[] = 'Le titre ne doit pas dépasser 255 caractères.';
            }*/
            /*
            if (!filter_var($comicBook['isbn'], FILTER_VALIDATE_INT)) {
                $errors[] = 'L\'ISBN est obligatoirement composé de chiffres.';
            }*/
            /*
            if ($comicBook['isbn'] < 9780000000000 && $comicBook['isbn'] > 9799999999999) {
                $errors[] = 'L\'ISBN est composé de 13 chiffres commençant par 978 ou 979.';
            }*/
            /*
            if ($comicBook['author_name'] > 100) {
                $errors[] = 'Le champ "Auteur" ne doit pas dépasser 100 caractères.';
            }*/
            /*
            if (!filter_var($comicBook['volume'], FILTER_VALIDATE_INT)) {
                $errors[] = 'Le nombre de tomes doit être composé de chiffres.';
            }*/
        }

        return $this->twig->render('Admin/add.html.twig');
    }
}
