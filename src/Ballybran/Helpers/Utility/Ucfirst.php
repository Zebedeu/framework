<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Utility;

class Ucfirst
{


    /**
     * @param string $post
     * @param array $char
     * @return string
     */
    public static function _ucfirst($post, $char = array("'", "-", " ")) : string
    {

        $string = strtolower($post);
        foreach ($char as $temp) {
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
    /**
     * @param string $strString
     * @param int $intLength
     * @return string
     */
    public static function abbreviate($strString, $intLength = NULL) : string
    {
        $defaultAbbrevLength = 8; //Default abbreviation length if none is specified

        //Set up the string for processing
        $strString = preg_replace("/[^A-Za-z0-9]/", '', $strString); //Remove non-alphanumeric characters
        $strString = ucfirst($strString); //Capitalize the first character (helps with abbreviation calcs)
        $stringIndex = 0;
        //Figure out everything we need to know about the resulting abbreviation string
        $uppercaseCount = preg_match_all('/[A-Z]/', $strString, $uppercaseLetters, PREG_OFFSET_CAPTURE); //Record occurences of uppercase letters and their indecies in the $uppercaseLetters array, take note of how many there are
        $targetLength = isset($intLength) ? intval($intLength) : $defaultAbbrevLength; //Maximum length of the abbreviation
        $uppercaseCount = $uppercaseCount > $targetLength ? $targetLength : $uppercaseCount; //If there are more uppercase letters than the target length, adjust uppercaseCount to ignore overflow
        $targetWordLength = round($targetLength / intval($uppercaseCount)); //How many characters need to be taken from each uppercase-designated "word" in order to best meet the target length?
        $abbrevLength = 0; //How long the abbreviation currently is
        $abbreviation = ''; //The actual abbreviation
        //Create respective arrays for the occurence indecies and the actual characters of uppercase characters within the string
        for ($i = 0; $i < $uppercaseCount; $i++) {
            //$ucIndicies[] = $uppercaseLetters[1];  //Not actually used. Could be used to calculate abbreviations more efficiently than the routine below by strictly considering indecies
            $ucLetters[] = $uppercaseLetters[0][$i][0];
        }
        $characterDeficit = 0; //Gets incremented when an uppercase letter is encountered before $targetCharsPerWord characters have been collected since the last UC char.
        $wordIndex = $targetWordLength; //HACK: keeps track of how many characters have been carried into the abbreviation since the last UC char
        while ($stringIndex < strlen($strString)) {  //Process the whole input string...
            if ($abbrevLength >= $targetLength)              //...unless the abbreviation has hit the target length cap
                break;
            $currentChar = $strString[$stringIndex++]; //Grab a character from the string, advance the string cursor
            if (in_array($currentChar, $ucLetters)) {           //If handling a UC char, consider it a new word
                $characterDeficit += $targetWordLength - $wordIndex; //If UC chars are closer together than targetWordLength, keeps track of how many extra characters are required to fit the target length of the abbreviation
                $wordIndex = 0; //Set the wordIndex to reflect a new word
            } else if ($wordIndex >= $targetWordLength) {
                if ($characterDeficit == 0)                //If the word is full and we're not short any characters, ignore the character
                    continue;
                else
                    $characterDeficit--; //If we are short some characters, decrement the defecit and carry on with adding the character to the abbreviation
            }
            $abbreviation .= $currentChar; //Add the character to the abbreviation
            $abbrevLength++; //Increment abbreviation length
            $wordIndex++; //Increment the number of characters for this word
        }
        return $abbreviation;
    }

    /**
    * example removeAccentsIstring( "Õ") output "O"
    * @param string $string
    * @return string
	*/
    public static function removeAccentsIstring($string) : string
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);

    }
    /**
     * @param string $string
     * @param bool 
     * @return string
     */
    public static function removeAccents($string, $slug = false) : string
    {
        $string = strtolower($string);
        // ASCII code of vowels
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        // ASCII code for other characters
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);
        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item AS $codigo) {
                $acentos .= chr($codigo);
            }
            $troca[$key] = '/[' . $acentos . ']/i';
        }
        $string = preg_replace(array_values($troca), array_keys($troca), $string);
        // Slug?
        if ($slug) {
            // Swap anything that is not letter or number for a character ($slug)           
                $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
            // Removes repeated characters ($slug)             
            $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        }
        return $string;
    }


}
