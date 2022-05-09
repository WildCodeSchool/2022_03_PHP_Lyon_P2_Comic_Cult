<?php

namespace App\Service;

use App\Service\UtilityService;

class AddComicService extends UtilityService
{
    private array $checkErrors = [];


    public function getCheckErrors(): array
    {
        return $this->checkErrors;
    }

    /**
     * Function only usefull for a comic book INSERT or UPDATE request.
     */
    public function comicBookEmptyVerify(array $comicBook): void
    {
        if (
            empty($comicBook['title']) || empty($comicBook['date_of_release']) ||
            empty($comicBook['category_id']) || empty($comicBook['pitch'])
        ) {
            $this->checkErrors[] = 'Les champs munis d\'un "*" sont obligatoires.';
        }
    }

    /**
     * Function only usefull for a comic book INSERT or UPDATE request.
     */
    public function comicBookStringVerify(array $comicBook): void
    {
        if (strlen($comicBook['title']) > 255) {
            $this->checkErrors[] = 'Le titre ne doit pas dépasser 255 caractères.';
        }
    }

    /**
     * Function only usefull for a comic book INSERT or UPDATE request
     */
    public function comicIsbnValidate(array $comicBook): void
    {
        if (!empty($comicBook['isbn']) && !filter_var($comicBook['isbn'], FILTER_VALIDATE_INT)) {
            $this->checkErrors[] = 'L\'ISBN est obligatoirement composé de chiffres.';
        }
        if (!empty($comicBook['isbn']) && ($comicBook['isbn'] < 9780000000000 || $comicBook['isbn'] > 9799999999999)) {
            $this->checkErrors[] = 'L\'ISBN est composé de 13 chiffres commençant par 978 ou 979.';
        }
    }
    /**
     * Function only usefull for a comic book INSERT or UPDATE request
     */
    public function comicBookNumberValidate(array $comicBook): void
    {
        if (!empty($comicBook['volume']) && !filter_var($comicBook['volume'], FILTER_VALIDATE_INT)) {
            $this->checkErrors[] = 'Le numéro du volume doit être composé de chiffres.';
        }
        if (!empty($comicBook['nb_pages']) && !filter_var($comicBook['nb_pages'], FILTER_VALIDATE_INT)) {
            $this->checkErrors[] = 'Le nombre de pages ne peut pas être écrit avec des lettres.';
        }
        if (!empty($comicBook['price']) && !filter_var($comicBook['price'], FILTER_VALIDATE_FLOAT)) {
            $this->checkErrors[] = 'Le prix doit contenir obligatoirement deux chiffres après la virgule.';
        }
    }

    public function coverIntegrityVerify(array $coverToUpload): void
    {
        $extension = pathinfo($coverToUpload['cover']['name'], PATHINFO_EXTENSION);
        $authorizedExtensions = ['jpg','jpeg','png'];
        $maxFileSize = 2000000;

        if ((!in_array($extension, $authorizedExtensions))) {
            $this->checkErrors[] = 'Veuillez sélectionner une image de type JGG, JPEG ou PNG.';
        }
        if (
            file_exists($coverToUpload['cover']['tmp_name'])
            && filesize($coverToUpload['cover']['tmp_name']) > $maxFileSize
        ) {
            $this->checkErrors[] = "Votre fichier doit faire moins de 2 Mo.";
        }
    }
}
