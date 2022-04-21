<?php

namespace App\Service;

class UtilityService
{
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
}
