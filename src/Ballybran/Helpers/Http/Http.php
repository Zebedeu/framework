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

namespace Ballybran\Helpers\Http;

/**
 * Class Http
 * @package Ballybran\Helpers\Security
 */
abstract class Http extends \ArrayObject
{


    private static $agent;


//    private static $language;


//    private static $unknown = 'Unknown';


    private static $_arguments = array(
        'browser' => NULL,
        'platform' => NULL,
        'robot' => NULL,
        'mobile' => NULL,
        'version' => NULL,
        'languages' => NULL
    );


    private static $_is = array(
        'browser' => FALSE,
        'robot' => FALSE,
        'mobile' => FALSE
    );


    private static $_browsers = array(
        '/(amaya)[ \/]([\w.]+)/' => 'Amaya',
        '/(Camino)[ \/]([\w.]+)/' => 'Camino',
        '/(Chimera)[ \/]([\w.]+)/' => 'Chimera',
        '/(Chrome)[ \/]([\w.]+)/' => 'Chrome',
        '/(Firebird)[ \/]([\w.]+)/' => 'Firebird',
        '/(Firefox)[ \/]([\w.]+)/' => 'Firefox',
        '/(Flock)[ \/]([\w.]+)/' => 'Flock',
        '/(hotjava)[ \/]([\w.]+)/' => 'HotJava',
        '/(IBrowse)[ \/]([\w.]+)/' => 'IBrowse',
        '/(Internet Explorer)[ \/]([\w.]+)/' => 'Internet Explorer',
        '/(MSIE)[ \/]([\w.]+)/' => 'Internet Explorer',
        '/(Konqueror)[ \/]([\w.]+)/' => 'Konqueror',
        '/(Links)[ \/]([\w.]+)/' => 'Links',
        '/(Lynx)[ \/]([\w.]+)/' => 'Lynx',
        '/(Mozilla)[ \/]([\w.]+)/' => 'Mozilla',
        '/(Netscape)[ \/]([\w.]+)/' => 'Netscape',
        '/(OmniWeb)[ \/]([\w.]+)/' => 'OmniWeb',
        '/(Opera)[ \/]([\w.]+)/' => 'Opera',
        '/(Phoenix)[ \/]([\w.]+)/' => 'Phoenix',
        '/(Safar)[ \/]([\w.]+)/' => 'Safari',
        '/(Shiira)[ \/]([\w.]+)/' => 'Shiira',
        '/(icab)[ \/]([\w.]+)/' => 'iCab');


    private static $_platforms = array(
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );


    private static $_robots = array(
        "askjeeves" => "AskJeeves",
        "fastcrawler" => "FastCrawler",
        "googlebot" => "Googlebot",
        "infoseek" => "InfoSeek Robot 1.0",
        "slurp" => "Inktomi Slurp",
        "lycos" => "Lycos",
        "msnbot" => "MSNBot",
        "yahoo" => "Yahoo"
    );


    private static $_mobiles = array(
        "alcatel" => "Alcatel",
        "amoi" => "Amoi",
        "iphone" => "Apple iPhone",
        "ipod" => "Apple iPod Touch",
        "avantgo" => "AvantGo",
        "benq" => "BenQ",
        "blackberry" => "BlackBerry",
        "hiptop" => "Danger Hiptop",
        "digital paths" => "Digital Paths",
        "cldc" => "Generic Mobile",
        "mobile" => "Generic Mobile",
        "wireless" => "Generic Mobile",
        "midp" => "Generic Mobile",
        "j2me" => "Generic Mobile",
        "smartphone" => "Generic Mobile",
        "up.browser" => "Generic Mobile",
        "cellphone" => "Generic Mobile",
        "up.link" => "Generic Mobile",
        "ipaq" => "HP iPaq",
        "htc" => "HTC",
        "lg" => "LG",
        "mda" => "MDA",
        "mobileexplorer" => "Mobile Explorer",
        "mobilexplorer" => "Mobile Explorer",
        "motorola" => "Motorola",
        "mot-" => "Motorola",
        "nec-" => "NEC",
        "docomo" => "NTT DoCoMo",
        "netfront" => "Netfront Browser",
        "nokia" => "Nokia",
        "novarra" => "Novarra Transcoder",
        "o2" => "O2",
        "cocoon" => "O2 Cocoon",
        "obigo" => "Obigo",
        "openwave" => "Openwave Browser",
        "operamini" => "Opera Mini",
        "opera mini" => "Opera Mini",
        "palm" => "Palm",
        "elaine" => "Palm",
        "palmsource" => "Palm",
        "palmscape" => "Palmscape",
        "panasonic" => "Panasonic",
        "philips" => "Philips",
        "playstation portable" => "PlayStation Portable",
        "spv" => "SPV",
        "sagem" => "Sagem",
        "samsung" => "Samsung",
        "sanyo" => "Sanyo",
        "sendo" => "Sendo",
        "sharp" => "Sharp",
        "sie-" => "Siemens",
        "ericsson" => "Sony Ericsson",
        "sony" => "Sony Ericsson",
        "symbian" => "Symbian",
        "series60" => "Symbian S60",
        "SymbianOS" => "SymbianOS",
        "blazer" => "Treo",
        "vario" => "Vario",
        "vodafone" => "Vodafone",
        "windows ce" => "Windows CE",
        "xda" => "XDA",
        "xiino" => "Xiino",
        "zte" => "ZTE",
        "ipad" => "iPad"
    );

    public function __construct($input = [], $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct($input, $flags, $iterator_class);

    }


    /**
     * @return string
     */
    public static function http_user_agent()
    {
        return ((isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : NULL);
    }

    /**
     * @return string
     */
    public static function accept_language(): string
    {
        return ((isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? trim($_SERVER['HTTP_ACCEPT_LANGUAGE']) : NULL);
    }

    public static function referer()
    {
        return (isset($_SERVER['HTTP_REFERER'])) ? trim($_SERVER['HTTP_REFERER']) : NULL;

    }


    /**
     * Checking browsers names
     *
     * @access private
     * @static
     */
    public static function browser()
    {
        foreach (self::$_browsers as $key => $value) {
            if (preg_match($key, self::http_user_agent())) {
                self::$_arguments['browser'] = $value;

                self::$_is['browser'] = TRUE;
                self::mobile();
                break;
            }
        }
        $return = "";
        $return .= self::$_arguments['browser'];
        $return .= self::mobile();
        return $return;


    }

    /**
     * @return mixed
     */
    public static function platforms()
    {
        foreach (self::$_platforms as $key => $platform) {

            if (preg_match($key, self::http_user_agent())) {

                self::$_arguments['platform'] = $platform;

            }

        }
        return self::$_arguments['platform'];

    }

    public static function getAllInformation()
    {
        $re = "";
        $re .= self::accept_language();
        $re .= self::platforms();
        $re .= self::browser();
        $re .= self::version();
//        $re .= self::http_user_agent();

        return $re;
    }

    /**
     * Checking robots names
     *
     * @access private
     * @static
     */
    public static function robot()
    {
        foreach (self::$_robots as $key => $value) {
            if (preg_match("|" . preg_quote($key) . "|i", self::$agent)) {
                self::$_is['robot'] = TRUE;
                self::$_arguments['robot'] = $value;
                break;
            }
        }
    }

    /**
     * Checking mobiles names
     *
     * @access private
     * @static
     */
    public static function mobile()
    {
        foreach (self::$_mobiles as $key => $value) {
            if (FALSE !== (strpos(mb_strtolower(self::http_user_agent()), $key))) {
                self::$_is['mobile'] = TRUE;
                return self::$_arguments['mobile'] = $value;
            }
        }
    }

    /**
     * Checking languages
     *
     * @access private
     * @static
     */
    public static function isEmptyLanguage()
    {
        if ((count(self::$_arguments['languages']) == 0) && self::accept_language() != '') {
            $languages = preg_replace('/(;q=[0-9\.]+)/i', '', mb_strtolower(self::accept_language()));

            self::$_arguments['languages'] = explode(',', $languages);
        }
        self::$_arguments['languages'] = array('Undefined');

    }

    /**
     * Get version as string
     *
     * @access public
     * @static
     */
    public static function version()
    {
        foreach (self::$_browsers as $key => $value) {
            if (preg_match($key, self::http_user_agent(), $math)) {
                self::$_arguments['version'] = $math[2];
                self::mobile();
                break;
            }
        }
        $return = "";
        $return .= self::$_arguments['version'];

        $return .= self::mobile();
        return $return;
    }

    /**
     * Is browser
     *
     * @access public
     * @static
     */
    public static function is_browser()
    {
        return (boolean)self::$_is['browser'];
    }

    /**
     * Is mobile
     *
     * @access public
     * @static
     */
    public static function is_mobile()
    {
        return (boolean)self::$_is['mobile'];
    }

    /**
     * @return bool
     */
    public static function is_robot()
    {
        return (boolean)self::$_is['robot'];
    }

}
