<?php

namespace App\Service;

class UtilityService
{
    /**
     * Function used to clean a string when a user make a search request
     */
    public function clearString(string $stringToClear): string
    {
        $characterToReplace = ['\'', '"', ',', '-', '.', ':', ';', '?', '!'];
        $accentsToReplace = [['à' => 'a'], ['â', 'a'],
                            ['é' => 'e'], ['è' => 'e'], ['ê' => 'e'], ['ë' => 'e'],
                            ['î' => 'i'], ['ï' => 'i'],
                            ['ô' => 'o'], ['ö' => 'o'],
                            ['ù' => 'u'], ['û' => 'u'], ['ü', 'u']];
        $wordsToReplace = ['un', 'une', 'des', 'le', 'la', 'les', 'au', 'aux', 'du',
                            'mon', 'notre', 'votre', 'nos', 'vos', 'leur', 'leurs',
                            'ai', 'avons', 'avez', 'ont', 'suis', 'es', 'êtes', 'sont',
                            'a', 'l', 'd', 's', 'm'];

        $stringToClear = strtolower($stringToClear);
        $stringToClear = str_replace($characterToReplace, ' ', $stringToClear);
        foreach ($accentsToReplace as $key => $value) {
            foreach ($value as $accentWord => $word) {
                $stringToClear = str_replace($accentWord, $word, $stringToClear);
            }
        }
        $stringToClear = trim($stringToClear);
        // fonction used to clear all spaces between words.
        $stringToClear = preg_replace('/\s\s+/', ' ', $stringToClear);
        $stringToClear = explode(' ', $stringToClear);
        foreach ($wordsToReplace as $key => $word) {
            foreach ($stringToClear as $key => $keyword) {
                if (strcmp($word, $keyword) == 0) {
                    $stringToClear[$key] = ' ';
                }
            }
        }
        $clearedString = implode(' ', $stringToClear);

        return $clearedString;
    }

    /**
     * Function only usefull for a comic book INSERT or UPDATE request.
     */
    public function comicBookEmptyVerify(array $comicBook): array
    {
        $emptyErrors = [];
        if (
            empty($comicBook['title']) || empty($comicBook['date_of_release']) ||
            empty($comicBook['category']) || empty($comicBook['author_name'])  ||
            empty($comicBook['pitch'])
        ) {
            $emptyErrors[] = 'Les champs munis d\'un "*" sont obligatoires.';
        }

        return $emptyErrors;
    }

    /**
     * Function only usefull for a comic book INSERT or UPDATE request.
     */
    public function comicBookStringVerify(array $comicBook): array
    {
        $stringErrors = [];
        if ($comicBook['title'] > 255) {
            $stringErrors[] = 'Le titre ne doit pas dépasser 255 caractères.';
        }
        if ($comicBook['author_name'] > 100) {
            $stringErrors[] = 'Le champ "Auteur" ne doit pas dépasser 100 caractères.';
        }

        return $stringErrors;
    }

    /**
     * Function only usefull for a comic book INSERT or UPDATE request
     */
    public function comicBookNumberValidate(array $comicBook): array
    {
        $numberErrors = [];
        if (!filter_var($comicBook['isbn'], FILTER_VALIDATE_INT)) {
            $numberErrors[] = 'L\'ISBN est obligatoirement composé de chiffres.';
        }
        if ($comicBook['isbn'] < 9780000000000 && $comicBook['isbn'] > 9799999999999) {
            $numberErrors[] = 'L\'ISBN est composé de 13 chiffres commençant par 978 ou 979.';
        }
        if (!filter_var($comicBook['volume'], FILTER_VALIDATE_INT)) {
            $numberErrors[] = 'Le nombre de tomes doit être composé de chiffres.';
        }
        if (!filter_var($comicBook['nb_pages'], FILTER_VALIDATE_INT)) {
            $numberErrors[] = 'Le nombre de pages ne peut pas être écrit avec des lettres.';
        }
        if (!filter_var($comicBook['price'], FILTER_VALIDATE_FLOAT)) {
            $numberErrors[] = 'Le prix doit contenir obligatoirement deux chiffres après la virgule.';
        }

        return $numberErrors;
    }

    public function coverIntegrityVerify(array $file): array
    {
        $coverErrors = [];
        $extension = pathinfo($file['avatar']['name'], PATHINFO_EXTENSION);
        $authorizedExtensions = ['jpg','jpeg','png'];
        $maxFileSize = 2000000;

        if ((!in_array($extension, $authorizedExtensions))) {
            $coverErrors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
        }
        if (file_exists($file['avatar']['tmp_name']) && filesize($file['avatar']['tmp_name']) > $maxFileSize) {
            $coverErrors[] = "Votre fichier doit faire moins de 2M !";
        }

        return $coverErrors;
    }
}
