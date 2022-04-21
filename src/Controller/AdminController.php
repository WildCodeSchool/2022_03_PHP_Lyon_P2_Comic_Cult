<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Service\AddComicService;

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
        $cleanComicBook = new AddComicService();
        $adminManager = new AdminManager();
        $errors = [];

        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $comicBook = array_map('trim', $_POST);
            // Three function in UtilityService to clean comic book's datas.
            $cleanComicBook->comicBookEmptyVerify($comicBook);
            $cleanComicBook->comicBookEmptyVerify($comicBook);
            $cleanComicBook->comicBookNumberValidate($comicBook);
            $cleanComicBook->comicBookStringVerify($comicBook);
            $comicBook['keywords'] = $cleanComicBook->clearString($comicBook['pitch']);

            $uploadDir = 'assets/images/comicUpload/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['cover']['name']);
            $comicBook['cover'] = $uploadFile;

            // Function to verify integrity of uploaded file.
            $cleanComicBook->coverIntegrityVerify($_FILES);

            $errors = $cleanComicBook->getCheckErrors();

            if (empty($cleanComicBook->getCheckErrors())) {
                move_uploaded_file($_FILES['cover']['tmp_name'], $uploadFile);
                $adminManager->insert($comicBook);
                header('Location: list');
            }
        }

        return $this->twig->render('Admin/add.html.twig', ['errors', $errors]);
    }
}
