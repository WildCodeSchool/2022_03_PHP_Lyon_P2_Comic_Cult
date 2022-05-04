<?php

namespace App\Service;

use App\Service\UtilityService;

class AddMessageService extends UtilityService
{
    private array $checkErrors = [];


    public function getCheckErrors(): array
    {
        return $this->checkErrors;
    }

    public function addMessageVerification(array $userMessage): void
    {
        if (
            empty($userMessage['firstname']) || empty($userMessage['lastname']) ||
            empty($userMessage['email']) || empty($userMessage['message'])
        ) {
            $this->checkErrors[] = 'Les champs sont obligatoires.';
        }
    }

    public function addMessage(array $userMessage): void
    {
        if (strlen($userMessage['firstname']) > 80) {
            $this->checkErrors[] = 'Le prénom de l\'auteur ne doit pas dépasser 80 caractères.';
        }
        if (strlen($userMessage['last_name']) > 100) {
            $this->checkErrors[] = 'Le nom de l\'auteur ne doit pas dépasser 100 caractères.';
        }

        if (strlen($userMessage['email']) > 320) {
            $this->checkErrors[] = 'Votre email ne doit pas dépasser 320 caractères.';
        }

        if (strlen($userMessage['message']) > 1000) {
            $this->checkErrors[] = 'Votre message ne doit pas dépasser 1000 caractères.';
        }
    }
}
