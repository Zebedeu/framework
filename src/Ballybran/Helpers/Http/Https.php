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

namespace Ballybran\Helpers\Http;
/**
 * Class Http
 * @package Ballybran\Helpers\Security
 */
class Https {

    /**
     * Get server HTTP_USER_AGENT
     *
     * @var string $agent
     *
     * @access private
     * @static
     */
    private static $agent;
    /**
     * Get server HTTP_ACCEPT_LANGUAGE
     *
     * @var string $language
     *
     * @access private
     * @static
     */
    private static $language;
    /**
     * @var (string) $unknown - Unknown name.
     * @access protected.
     */
    /**
     * Unknown name
     *
     * @var $unknown
     *
     * @access private
     * @static
     */
    private static $unknown = 'Unknown';
    /**
     * http user agent data arguments as array
     *
     * @var array $_arguments
     *                       string key 'browser'   browser name
     *                       string key 'platform'  platform name
     *                       string key 'robot'     robot name
     *                       string key 'mobile'    mobile name
     *                       string key 'browser'   browser name
     *                       string key 'languages' get language
     *
     * @access private
     * @static
     */
    private static $_arguments = array(
        'browser'   => NULL,
        'platform'  => NULL,
        'robot'     => NULL,
        'mobile'    => NULL,
        'version'   => NULL,
        'languages' => NULL
    );
    /**
     * is a browser or robot or mobile
     *
     * @var array $_is
     *
     * @access private
     * @static
     */
    private static $_is = array(
        'browser'  => FALSE,
        'robot'    => FALSE,
        'mobile'   => FALSE
    );
    /**
     * Browsers names
     *
     * @var array $_browsers
     *
     * @access private
     * @static
     */
    private static $_browsers = array(
        'amaya'             => 'Amaya',
        'Camino'            => 'Camino',
        'Chimera'           => 'Chimera',
        'Chrome'            => 'Chrome',
        'Firebird'          => 'Firebird',
        'Firefox'           => 'Firefox',
        'Flock'             => 'Flock',
        'hotjava'           => 'HotJava',
        'IBrowse'           => 'IBrowse',
        'Internet Explorer' => 'Internet Explorer',
        'MSIE'              => 'Internet Explorer',
        'Konqueror'         => 'Konqueror',
        'Links'             => 'Links',
        'Lynx'              => 'Lynx',
        'Mozilla'           => 'Mozilla',
        'Netscape'          => 'Netscape',
        'OmniWeb'           => 'OmniWeb',
        'Opera'             => 'Opera',
        'Phoenix'           => 'Phoenix',
        'Safari'            => 'Safari',
        'Shiira'            => 'Shiira',
        'icab'              => 'iCab');
    /**
     * Platforms names
     *
     * @var array $_platforms
     *
     * @access private
     * @static
     */
    private static $_platforms = array (
        "aix"            => "AIX",
        "apachebench"    => "ApacheBench",
        "bsdi"           => "BSDi",
        "beos"           => "BeOS",
        "osf"            => "DEC OSF",
        "debian"         => "Debian",
        "freebsd"        => "FreeBSD",
        "gnu"            => "GNU/Linux",
        "hp-ux"          => "HP-UX",
        "irix"           => "Irix",
        "linux"          => "Linux",
        "os x"           => "Mac OS X",
        "ppc"            => "Macintosh",
        "netbsd"         => "NetBSD",
        "openbsd"        => "OpenBSD",
        "ppc mac"        => "Power PC Mac",
        "sunos"          => "Sun Solaris",
        "unix"           => "Unknown Unix OS",
        "windows"        => "Unknown Windows OS",
        "windows nt 5.0" => "Windows 2000",
        "windows nt 5.2" => "Windows 2003",
        "windows 95"     => "Windows 95",
        "win95"          => "Windows 95",
        "windows 98"     => "Windows 98",
        "win98"          => "Windows 98",
        "windows nt 6.0" => "Windows Longhorn",
        "winnt 4.0"      => "Windows NT",
        "winnt"          => "Windows NT",
        "winnt4.0"       => "Windows NT 4.0",
        "windows nt 4.0" => "Windows NT 4.0",
        "windows nt 5.1" => "Windows XP"
    );
    /**
     * Robots names
     *
     * @var array $_robots
     *
     * @access private
     * @static
     */
    private static $_robots = array(
        "askjeeves"   => "AskJeeves",
        "fastcrawler" => "FastCrawler",
        "googlebot"   => "Googlebot",
        "infoseek"    => "InfoSeek Robot 1.0",
        "slurp"       => "Inktomi Slurp",
        "lycos"       => "Lycos",
        "msnbot"      => "MSNBot",
        "yahoo"       => "Yahoo"
    );
    /**
     * Mobiles names
     *
     * @var array $_mobiles
     *
     * @access private
     * @static
     */
    private static $_mobiles = array(
        "alcatel"              => "Alcatel",
        "amoi"                 => "Amoi",
        "iphone"               => "Apple iPhone",
        "ipod"                 => "Apple iPod Touch",
        "avantgo"              => "AvantGo",
        "benq"                 => "BenQ",
        "blackberry"           => "BlackBerry",
        "hiptop"               => "Danger Hiptop",
        "digital paths"        => "Digital Paths",
        "cldc"                 => "Generic Mobile",
        "mobile"               => "Generic Mobile",
        "wireless"             => "Generic Mobile",
        "midp"                 => "Generic Mobile",
        "j2me"                 => "Generic Mobile",
        "smartphone"           => "Generic Mobile",
        "up.browser"           => "Generic Mobile",
        "cellphone"            => "Generic Mobile",
        "up.link"              => "Generic Mobile",
        "ipaq"                 => "HP iPaq",
        "htc"                  => "HTC",
        "lg"                   => "LG",
        "mda"                  => "MDA",
        "mobileexplorer"       => "Mobile Explorer",
        "mobilexplorer"        => "Mobile Explorer",
        "motorola"             => "Motorola",
        "mot-"                 => "Motorola",
        "nec-"                 => "NEC",
        "docomo"               => "NTT DoCoMo",
        "netfront"             => "Netfront Browser",
        "nokia"                => "Nokia",
        "novarra"              => "Novarra Transcoder",
        "o2"                   => "O2",
        "cocoon"               => "O2 Cocoon",
        "obigo"                => "Obigo",
        "openwave"             => "Openwave Browser",
        "operamini"            => "Opera Mini",
        "opera mini"           => "Opera Mini",
        "palm"                 => "Palm",
        "elaine"               => "Palm",
        "palmsource"           => "Palm",
        "palmscape"            => "Palmscape",
        "panasonic"            => "Panasonic",
        "philips"              => "Philips",
        "playstation portable" => "PlayStation Portable",
        "spv"                  => "SPV",
        "sagem"                => "Sagem",
        "samsung"              => "Samsung",
        "sanyo"                => "Sanyo",
        "sendo"                => "Sendo",
        "sharp"                => "Sharp",
        "sie-"                 => "Siemens",
        "ericsson"             => "Sony Ericsson",
        "sony"                 => "Sony Ericsson",
        "symbian"              => "Symbian",
        "series60"             => "Symbian S60",
        "SymbianOS"            => "SymbianOS",
        "blazer"               => "Treo",
        "vario"                => "Vario",
        "vodafone"             => "Vodafone",
        "windows ce"           => "Windows CE",
        "xda"                  => "XDA",
        "xiino"                => "Xiino",
        "zte"                  => "ZTE",
        "ipad"                 => "iPad"
    );

    public function __construct()
    {
        self::$agent    = self::http_user_agent();
        self::$language = self::accept_language();
        self::initializing();
    }


    public static function http_user_agent ()
    {
        return ((isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : NULL);
    }

    public static function accept_language()
    {
        return ((isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? trim($_SERVER['HTTP_ACCEPT_LANGUAGE']) : NULL);
    }


    public static function referer ()
    {
        return (isset($_SERVER['HTTP_REFERER'])) ? trim($_SERVER['HTTP_REFERER']) : NULL;
    }
    /**
     * The Host name from which the user is viewing the current page
     *
     * @access public
     * @static
     */
    public static function ip ()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            $ip = $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            $ip = $_SERVER["HTTP_FORWARDED"];
        }
        else if (isset($_SERVER["REMOTE_ADDR"]))
        {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        else
        {
            $ip = getenv("REMOTE_ADDR");
        }
        return $ip;
    }


    public static function as_string ()
    {
        $string = "<pre>";
        $string .= "<h2 style=\"margin: 0;\">http information :</h2>\n";
        $string .= "<strong>Platform</strong> : ".self::platform()."\n";
        $string .= "<strong>Browser</strong> : ".self::browser()."\n";
        $string .= "<strong>Browser version</strong> : ".self::version()."\n";
        if (self::is_mobile() == TRUE)
        {
            $string .= "<strong>Mobile</strong> : ".self::mobile()."\n";
        }
        if (self::is_robot() == TRUE)
        {
            $string .= "<strong>Robot</strong> : ".self::robot()."\n";
        }
        $string .= "<strong>USER AGENT </strong> : ".self::agent()."\n";
        $string .= "<strong>Accept languages </strong> : ";
        $languages = "";
        foreach (self::languages() as $key => $value)
        {
            $string .= $value." ";
        }
        $string .= "\n";
        $string .= "</pre>";
        return $string;
    }


    private static function initializing ()
    {
        self::set_platform();
        self::set_languages();
        $set = array('set_robot', 'set_browser', 'set_mobile');
        foreach ($set as $function)
        {
            if (self::$function() === TRUE)
            {
                break;
            }
        }
    }


    private static function set_platform ()
    {
        foreach (self::$_platforms as $key => $value)
        {
            if (preg_match("|".preg_quote($key)."|i",self::$agent))
            {
                self::$_arguments['platform'] = $value;
                break;
            }
            else
            {
                self::$_arguments['platform'] = self::$unknown;
            }
        }
    }


    private static function set_browser ()
    {
        foreach (self::$_browsers as $key => $value)
        {
            if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i",self::$agent,$match))
            {
                self::$_arguments['browser'] = $value;
                self::$_arguments['version'] = $match[1];
                self::$_is['browser'] = TRUE;
                self::set_mobile();
                break;
            }
            else
            {
                self::$_arguments['browser'] = self::$unknown;
                self::$_arguments['version'] = self::$unknown;
                self::set_mobile();
            }
        }
    }


    private static function set_robot ()
    {
        foreach (self::$_robots as $key => $value)
        {
            if (preg_match("|".preg_quote($key)."|i",self::$agent))
            {
                self::$_is['robot']        = TRUE;
                self::$_arguments['robot'] = $value;
                break;
            }
        }
    }


    private static function set_mobile ()
    {
        foreach (self::$_mobiles as $key => $value)
        {
            if (FALSE !== (strpos(mb_strtolower(self::$agent),$key)))
            {
                self::$_is['mobile']        = TRUE;
                self::$_arguments['mobile'] = $value;
                break;
            }
        }
    }


    private static function set_languages ()
    {
        if ((count(self::$_arguments['languages']) == 0) && self::$language != '')
        {
            $languages = preg_replace('/(;q=[0-9\.]+)/i','',mb_strtolower(self::$language));
            self::$_arguments['languages'] = explode(',',$languages);
        }
        if (count(self::$_arguments['languages']) == 0)
        {
            self::$_arguments['languages'] = array('Undefined');
        }
    }


    public static function platform ()
    {
        return self::$_arguments['platform'];
    }


    public static function browser ()
    {
        return self::$_arguments['browser'];
    }


    public static function mobile ()
    {
        return self::$_arguments['mobile'];
    }


    public static function robot ()
    {
        return self::$_arguments['robot'];
    }


    public static function version ()
    {
        return self::$_arguments['version'];
    }


    public static function is_browser () : bool
    {
        return  self::$_is['browser'];
    }

    public static function is_mobile () : bool
    {
        return self::$_is['mobile'];
    }


    public static function is_robot () : bool
    {
        return  self::$_is['robot'];
    }


    public static function languages ()
    {
        return  self::$_arguments['languages'];
    }
}