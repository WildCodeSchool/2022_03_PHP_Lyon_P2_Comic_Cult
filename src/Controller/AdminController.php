<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\AuthorManager;
use App\Model\GenreManager;
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
        $genreManager = new GenreManager();
        $comicGenres = $genreManager->selectAll();
        $errors = [];
        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $comicBook = array_map('trim', $_POST);
            // Three function in UtilityService to clean comic book's datas.
            $cleanComicBook->comicBookEmptyVerify($comicBook);
            $cleanComicBook->comicIsbnValidate($comicBook);
            $cleanComicBook->comicBookNumberValidate($comicBook);
            $cleanComicBook->comicBookStringVerify($comicBook);
            $comicBook['keywords'] = $cleanComicBook->clearString($comicBook['pitch']);
            $comicBook['title_keywords'] = $cleanComicBook->clearString($comicBook['title']);

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

        return $this->twig->render('Admin/add.html.twig', array('errors' => $errors, 'comicGenres' => $comicGenres));
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $adminManager = new AdminManager();
            $adminManager->delete((int)$id);

            header('Location:/admin/list');
        }
    }

    /**
     * Edit a specific item
     */
    public function edit($id): ?string
    {
        $cleanComicBook = new AddComicService();
        $adminManager = new AdminManager();
        $genreManager = new GenreManager();
        $comicGenres = $genreManager->selectAll();
        $comicById = $adminManager->selectOneById($id);
        $errors = [];
        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $comicBook = array_map('trim', $_POST);
            // Three function in UtilityService to clean comic book's datas.
            $cleanComicBook->comicBookEmptyVerify($comicBook);
            $cleanComicBook->comicIsbnValidate($comicBook);
            $cleanComicBook->comicBookNumberValidate($comicBook);
            $cleanComicBook->comicBookStringVerify($comicBook);
            $comicBook['keywords'] = $cleanComicBook->clearString($comicBook['pitch']);
            $comicBook['title_keywords'] = $cleanComicBook->clearString($comicBook['title']);

            $uploadDir = 'assets/images/comicUpload/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['cover']['name']);
            $comicBook['cover'] = $uploadFile;

            // Function to verify integrity of uploaded file.
            $cleanComicBook->coverIntegrityVerify($_FILES);

            $errors = $cleanComicBook->getCheckErrors();
            if (empty($cleanComicBook->getCheckErrors())) {
                move_uploaded_file($_FILES['cover']['tmp_name'], $uploadFile);
                $adminManager->update($comicBook, $id);
                header('Location: list');
            }
        }

        return $this->twig->render('Admin/edit.html.twig', array('errors' => $errors, 'comicBook' => $comicById,
                                    'comicGenres' => $comicGenres));
    }

    public function authorList(): string
    {
        $authorManager = new AuthorManager();
        $authors = $authorManager->selectAll();

        return $this->twig->render('Admin/author.html.twig', ['authors' => $authors]);
    }
    
    public function addAuthor(): string
    {
        return $this->twig->render('Admin/add_author.html.twig');
    }
}
