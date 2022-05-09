<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\AuthorManager;
use App\Model\GenreManager;
use App\Model\ContactManager;
use App\Service\AddComicService;
use Exception;
use App\Service\AddAuthorService;

class AdminController extends AbstractController
{
    public function list(): string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $adminManager = new AdminManager();
        $comics = $adminManager->selectAllComicsInJunction();
        $authors = $adminManager->selectAllAuthorsInJunction();

        return $this->twig->render('Admin/admin.html.twig', array('comics' => $comics,
                                                                    'authors' => $authors));
    }

    /**
     * Add a new item
     */
    public function add(): ?string
    {

        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $cleanComicBook = new AddComicService();
        $adminManager = new AdminManager();
        $genreManager = new GenreManager();
        $authorManager = new AuthorManager();
        $comicAuthors = $authorManager->selectAll();
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

        return $this->twig->render('Admin/add.html.twig', array('errors' => $errors,
                                                                'comicGenres' => $comicGenres,
                                                                'comicAuthors' => $comicAuthors));
    }

    public function delete(): void
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $adminManager = new AdminManager();
            $adminManager->delete((int)$id);

            header('Location:/admin/list');
        }
    }


    public function deleteAuthor(): ?string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authorId = trim($_POST['id']);
            $authorManager = new AuthorManager();
            try {
                $authorManager->delete((int)$authorId);
            } catch (Exception $error) {
                $error = 'Cet auteur est lié à une BD. Vous ne pouvez pas le supprimer.';
                return $this->twig->render('Admin/delete.html.twig', ['error' => $error]);
            }
            header('Location: /admin/author');
        }
        return null;
    }

    /**
     * Edit a specific item
     */
    public function edit($id): ?string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $cleanComicBook = new AddComicService();
        $adminManager = new AdminManager();
        $genreManager = new GenreManager();
        $authorManager = new AuthorManager();
        $comicGenres = $genreManager->selectAll();
        $comicAuthors = $adminManager->selectAllAuthorsInJunction();
        $authorList = $authorManager->selectAll();
        $comicById = $adminManager->selectOneById($id);
        $errors = [];

        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $comicBook = array_map('trim', $_POST);

            // Four functions in UtilityService to clean comic book's datas.
            $cleanComicBook->comicBookEmptyVerify($comicBook);
            $cleanComicBook->comicIsbnValidate($comicBook);
            $cleanComicBook->comicBookNumberValidate($comicBook);
            $cleanComicBook->comicBookStringVerify($comicBook);

            $comicBook['keywords'] = $cleanComicBook->clearString($comicBook['pitch']);
            $comicBook['title_keywords'] = $cleanComicBook->clearString($comicBook['title']);

            $authorsId = [];
            for ($key = 0; $key < 3; $key++) {
                if (isset($comicBook['author_id' . $key])) {
                    $authorsId[] = $comicBook['author_id' . $key];
                }
            }

            // This part update comic only if there is no cover to send
            if (empty($_FILES['cover']['name'])) {
                $comicBook['cover'] = $comicBook['cover_link'];
                $errors = $cleanComicBook->getCheckErrors();

                if (empty($cleanComicBook->getCheckErrors())) {
                    $adminManager->update($comicBook, $id);
                    $adminManager->updateJunctionComicAuthor($id, $authorsId);
                    header('Location: list');
                }
            }

            // This part update comic only if admin send a new cover
            $uploadDir = 'assets/images/comicUpload/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['cover']['name']);
            $comicBook['cover'] = $uploadFile;

            // Function to verify integrity of uploaded file.
            $cleanComicBook->coverIntegrityVerify($_FILES);

            $errors = $cleanComicBook->getCheckErrors();
            if (empty($cleanComicBook->getCheckErrors())) {
                move_uploaded_file($_FILES['cover']['tmp_name'], $uploadFile);
                $adminManager->update($comicBook, $id);
                $adminManager->updateJunctionComicAuthor($id, $authorsId);
                header('Location: list');
            }
        }

        return $this->twig->render('Admin/edit.html.twig', array('errors' => $errors, 'comicBook' => $comicById,
                                    'comicGenres' => $comicGenres, 'comicAuthors' => $comicAuthors,
                                    'authorList' => $authorList));
    }

    public function authorList(): string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $authorManager = new AuthorManager();
        $authors = $authorManager->selectAll();

        return $this->twig->render('Admin/author.html.twig', ['authors' => $authors]);
    }

    public function addAuthor(): string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $authorManager = new AuthorManager();
        $cleanComicAuthor = new AddAuthorService();
        $errors = [];
        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $comicAuthor = array_map('trim', $_POST);
            $cleanComicAuthor->comicAuthorEmptyVerify($comicAuthor);
            $cleanComicAuthor->comicAuthorStringVerify($comicAuthor);
            $comicAuthor['first_name_keyword'] = $cleanComicAuthor->clearString($comicAuthor['first_name']);
            $comicAuthor['last_name_keyword'] = $cleanComicAuthor->clearString($comicAuthor['last_name']);

            $errors = $cleanComicAuthor->getCheckErrors();

            if (empty($cleanComicAuthor->getCheckErrors())) {
                $authorManager->insertAuthor($comicAuthor);
                header('Location:/admin/author');
            }
        }

        return $this->twig->render('Admin/add_author.html.twig', ['errors' => $errors]);
    }

    /**
     * Update author table.
     */

    public function authorEdit($id)
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $authorManager = new AuthorManager();
        $cleanComicAuthor = new AddAuthorService();
        $authorById = $authorManager->selectOneById($id);
        $errors = [];
        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $comicAuthor = array_map('trim', $_POST);
            $cleanComicAuthor->comicAuthorEmptyVerify($comicAuthor);
            $cleanComicAuthor->comicAuthorStringVerify($comicAuthor);
            $comicAuthor['first_name_keyword'] = $cleanComicAuthor->clearString($comicAuthor['first_name']);
            $comicAuthor['last_name_keyword'] = $cleanComicAuthor->clearString($comicAuthor['last_name']);

            $errors = $cleanComicAuthor->getCheckErrors();
            if (empty($cleanComicAuthor->getCheckErrors())) {
                $authorManager->updateAuthor($comicAuthor, $id);
                header('Location:/admin/author');
            }
        }

        return $this->twig->render('Admin/edit_author.html.twig', array('errors' => $errors,
                                    'comicAuthor' => $authorById));
    }

    /**
     * List messages
     */
    public function messagesList(): string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        $contactManager = new ContactManager();
        $userMessages = $contactManager->selectAll();

        return $this->twig->render('Admin/contact.html.twig', ['userMessages' => $userMessages]);
    }

    /**
     * Delete a message
     */

    public function messageDelete(): void
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $adminManager = new AdminManager();
            $adminManager->messageDelete((int)$id);

            header('Location:/admin/contact');
        }
    }
}
