<?php

/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @see      https://github.com/knut7/framework/ for the canonical source repository
 *
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 *
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Time;

date_default_timezone_set(DEFAULT_UTC);

class Timestamp
{
    private static $tempo_da_sessao;

   public static function distanceOfTimeInWords($fromTime, $toTime = 0, $showLessThanAMinute = false)
   {
    $distanceInSeconds = round(abs($toTime - strtotime($fromTime)));
    $distanceInMinutes = round($distanceInSeconds / 60);

    if ($distanceInMinutes <= 1) {
        if (!$showLessThanAMinute) {
            return ($distanceInMinutes == 0) ? 'less than a minute' : '1 minute';
        } else {
            if ($distanceInSeconds < 5) {
                return 'less than 5 seconds';
            }
            if ($distanceInSeconds < 10) {
                return 'less than 10 seconds';
            }
            if ($distanceInSeconds < 20) {
                return 'less than 20 seconds';
            }
            if ($distanceInSeconds < 40) {
                return 'about half a minute';
            }
            if ($distanceInSeconds < 60) {
                return 'less than a minute';
            }

            return '1 minute';
        }
    }
    if ($distanceInMinutes < 45) {
        return $distanceInMinutes . ' minutes';
    }
    if ($distanceInMinutes < 90) {
        return 'about 1 hour';
    }
    if ($distanceInMinutes < 1440) {
        return 'about ' . round(floatval($distanceInMinutes) / 60.0) . ' hours';
    }
    if ($distanceInMinutes < 2880) {
        return '1 day';
    }
    if ($distanceInMinutes < 43200) {
        return 'about ' . round(floatval($distanceInMinutes) / 1440) . ' days';
    }
    if ($distanceInMinutes < 86400) {
        return 'about 1 month';
    }
    if ($distanceInMinutes < 525600) {
        return round(floatval($distanceInMinutes) / 43200) . ' months';
    }
    if ($distanceInMinutes < 1051199) {
        return 'about 1 year';
    }

    return 'over ' . round(floatval($distanceInMinutes) / 525600) . ' years';
}

    /**
     * dataTime.
     *
     * @param string $format
     *
     * @return string
     */
    public static function dataTime(string $format = 'Y-m-d H:i:s'): string
    {
        $data = new \DateTime();
        return $data->format($format);
        
    }

    public static function setDataTime($data, string $strftime='%d %B %Y', string $format = 'Y-m-d H:i:s')
    {
        $data = new \DateTime($data);
        $data_f = $data->format($format);

        // setlocale() used with strftime().
        $my_locale = setlocale(LC_ALL, MY_LOCALE);
        if (MY_LOCALE == true) {
            return $data_inicial = strftime($strftime, strtotime(trim($data_f)));
        } else {
            return $data_f = $data->format($format);
        }
    }

    public static function nicetime($date, array $translate = ["second", "minute", "hour", "day", "week", "month", "year", "decade"])
    {
        if(empty($date)) {
            return "No date provided";
        }
        if(!is_array($translate)) {
            return "the expected value is not an array";
        }
        if( 5 > count($translate)){
            return "the matrix needs 5 to 8 values (second, minute, hour, day, week,month, year, decade)";
        }

        $periods         = $translate;
        $lengths         = array("60","60","24","7","4.35","12","10");

        $now             = time();
        $unix_date         = strtotime($date);

       // check validity of date
        if(empty($unix_date)) {   
            return "Bad date";
        }

    // is it future date or past date
        if($now > $unix_date) {   
            $difference     = $now - $unix_date;
            $tense         = "ago";

        } else {
            $difference     = $unix_date - $now;
            $tense         = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

}
