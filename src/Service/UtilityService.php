<?php

namespace App\Service;

class UtilityService
{
    /**
     * Method used to clean a string when a user make a search request
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
     * Method used to csort temporary array of comics by keywords
     */
    public function sortByWords(array $keywords, array $comicBooks, string $option): array
    {
        $splitOption = [];
        $finalList = [];

        foreach ($keywords as $keyword) {
            $keyword['keyword'] = strtolower($keyword['keyword']);
            foreach ($comicBooks as $comicBook) {
                $comicOption = $this->clearString($comicBook[$option]);
                $comicOption = preg_replace('/\s\s+/', ' ', $comicOption);
                $splitOption = explode(" ", $comicOption);

                foreach ($splitOption as $word) {
                    if (strcmp($word, $keyword['keyword']) == 0) {
                        $finalList[] = $comicBook;
                    }
                }
            }
        }
        return $finalList;
    }

    /**
     * Method used to clean comic's duplicates
     */
    public function arrayUnique(array $comicBooks, string $key): array
    {
        $finalList = [];
        $arrayKey = 0;
        $temporaryArray = [];

        foreach ($comicBooks as $comicBook) {
            if (!in_array($comicBook[$key], $temporaryArray)) {
                $temporaryArray[$arrayKey] = $comicBook[$key];
                $finalList[$arrayKey] = $comicBook;
            }
            $arrayKey++;
        }
        return $finalList;
    }
}
