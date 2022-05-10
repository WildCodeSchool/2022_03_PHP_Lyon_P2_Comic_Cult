<?php

namespace App\Service;

use App\Service\UtilityService;
use DateTime;

class AddAuthorService extends UtilityService
{
    private array $checkErrors = [];


    public function getCheckErrors(): array
    {
        return $this->checkErrors;
    }

    public function comicAuthorEmptyVerify(array $comicAuthor): void
    {
        if (
            empty($comicAuthor['first_name']) || empty($comicAuthor['last_name']) ||
            empty($comicAuthor['birth_date']) || empty($comicAuthor['biography'])
        ) {
            $this->checkErrors[] = 'Les champs munis d\'un "*" sont obligatoires.';
        }
    }

    public function comicAuthorStringVerify(array $comicAuthor): void
    {
        if (strlen($comicAuthor['first_name']) > 80) {
            $this->checkErrors[] = 'Le prénom de l\'auteur ne doit pas dépasser 80 caractères.';
        }
        if (strlen($comicAuthor['last_name']) > 100) {
            $this->checkErrors[] = 'Le nom de l\'auteur ne doit pas dépasser 100 caractères.';
        }

        if (strlen($comicAuthor['editor']) > 100) {
            $this->checkErrors[] = 'Le nom de l\'éditeur ne doit pas dépasser 100 caractères.';
        }
    }

    public function comicAuthorDateVerify(array $comicAuthor): void
    {
        $dateOfTheDay = new DateTime('today');
        $dateOfTheDay = $dateOfTheDay->format('Y-m-d');
        if ($comicAuthor['birth_date'] >= $dateOfTheDay) {
            $this->checkErrors[] = 'La date de naissance ne peut pas être au-delà de la date du jour.';
        }
    }
}
