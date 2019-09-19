<?php

/**
 * KNUT7 K7F (http://framework.artphoweb.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */

namespace Ballybran\Helpers;

class Ucfirst
{


    /**
     * @param $post
     * @param array $a_char
     * @return string
     */
    public static function _ucfirst($post, $a_char = array("'", "-", " "))
    {

        $string = strtolower($post);
        foreach ($a_char as $temp) {
            $pos = strpos($string, $temp);

            if ($pos) {

                $mend = '';
                $a_split = explode($temp, $string);
                foreach ($a_split as $temp2) {
                    $mend .= ucfirst($temp2) . $temp;
                }
                $string = substr($mend, 0, -1);
            }
        }
        return ucfirst($string);
    }

    public static function abbreviate($strString, $intLength = NULL)
    {
        $defaultAbbrevLength = 8;   //Default abbreviation length if none is specified

        //Set up the string for processing
        $strString = preg_replace("/[^A-Za-z0-9]/", '', $strString);    //Remove non-alphanumeric characters
        $strString = ucfirst($strString);             //Capitalize the first character (helps with abbreviation calcs)
        $stringIndex = 0;
        //Figure out everything we need to know about the resulting abbreviation string
        $uppercaseCount = preg_match_all('/[A-Z]/', $strString, $uppercaseLetters, PREG_OFFSET_CAPTURE);  //Record occurences of uppercase letters and their indecies in the $uppercaseLetters array, take note of how many there are
        $targetLength = isset($intLength) ? intval($intLength) : $defaultAbbrevLength;                //Maximum length of the abbreviation
        $uppercaseCount = $uppercaseCount > $targetLength ? $targetLength : $uppercaseCount;                  //If there are more uppercase letters than the target length, adjust uppercaseCount to ignore overflow
        $targetWordLength = round($targetLength / intval($uppercaseCount));                                           //How many characters need to be taken from each uppercase-designated "word" in order to best meet the target length?
        $abbrevLength = 0;          //How long the abbreviation currently is
        $abbreviation = '';         //The actual abbreviation
        //Create respective arrays for the occurence indecies and the actual characters of uppercase characters within the string
        for ($i = 0; $i < $uppercaseCount; $i++) {
            //$ucIndicies[] = $uppercaseLetters[1];  //Not actually used. Could be used to calculate abbreviations more efficiently than the routine below by strictly considering indecies
            $ucLetters[] = $uppercaseLetters[0][$i][0];
        }
        $characterDeficit = 0;              //Gets incremented when an uppercase letter is encountered before $targetCharsPerWord characters have been collected since the last UC char.
        $wordIndex = $targetWordLength;         //HACK: keeps track of how many characters have been carried into the abbreviation since the last UC char
        while ($stringIndex < strlen($strString)) {  //Process the whole input string...
            if ($abbrevLength >= $targetLength)              //...unless the abbreviation has hit the target length cap
                break;
            $currentChar = $strString[$stringIndex++];    //Grab a character from the string, advance the string cursor
            if (in_array($currentChar, $ucLetters)) {           //If handling a UC char, consider it a new word
                $characterDeficit += $targetWordLength - $wordIndex;    //If UC chars are closer together than targetWordLength, keeps track of how many extra characters are required to fit the target length of the abbreviation
                $wordIndex = 0;                                                           //Set the wordIndex to reflect a new word
            } else if ($wordIndex >= $targetWordLength) {
                if ($characterDeficit == 0)                //If the word is full and we're not short any characters, ignore the character
                    continue;
                else
                    $characterDefecit--;                        //If we are short some characters, decrement the defecit and carry on with adding the character to the abbreviation
            }
            $abbreviation .= $currentChar;  //Add the character to the abbreviation
            $abbrevLength++;                        //Increment abbreviation length
            $wordIndex++;                             //Increment the number of characters for this word
        }
        return $abbreviation;
    }

    public static function removeAcentosInstring($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);

    }

    function removeAcentos($string, $slug = false)
    {
        $string = strtolower($string);
        // Código ASCII das vogais
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        // Código ASCII dos outros caracteres
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);
        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item AS $codigo) $acentos .= chr($codigo);
            $troca[$key] = '/[' . $acentos . ']/i';
        }
        $string = preg_replace(array_values($troca), array_keys($troca), $string);
        // Slug?
        if ($slug) {
            // Troca tudo que não for letra ou número por um caractere ($slug)
            $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
            // Tira os caracteres ($slug) repetidos
            $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        }
        return $string;
    }


}
