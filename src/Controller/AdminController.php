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

    /**
     * Add a new item
     */
    public function add(): ?string
    {
        $cleanComicBook = new UtilityService();

        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $errors = [];
            //$arrayOfErrors = [];
            $comicBook = array_map('trim', $_POST);
            // Three function in UtilityService to clean comic book's datas.
            $errors[] = $cleanComicBook->comicBookEmptyVerify($comicBook);
            $errors[] = $cleanComicBook->comicBookEmptyVerify($comicBook);
            var_dump($errors);
            /*
            foreach ($errors as $key => $value) {
                foreach ($value as $line) {
                    if (!empty($line)) {
                        $arrayOfErrors[] = $line;
                    }
                }
            }

            var_dump($arrayOfErrors);*/
            //die();
            $errors[] = $cleanComicBook->comicBookNumberValidate($comicBook);
            $errors[] = $cleanComicBook->comicBookStringVerify($comicBook);
            $comicBook['keywords'] = $cleanComicBook->clearString($comicBook['pitch']);

            $uploadDir = 'assets/images/comicUpload/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['cover']['name']);
            $comicBook['cover'] = $uploadFile;
            // Function to verify integrity of uploaded file.
            $errors[] = $cleanComicBook->coverIntegrityVerify($_FILES);


            /*
            if (empty($arrayOfErrors)) {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
            }*/
        }

        return $this->twig->render('Admin/add.html.twig');
    }
}
