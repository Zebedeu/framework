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

namespace Ballybran\Helpers\Http;
use Ballybran\Core\Http\{
    RestUtilities
};


/**
 * Class Cookie.
 */
class Cookie extends RestUtilities
{

    private static $default = [
        'name'=> null,
        'value'=>null,
        'maxage' => null,
        'expire' => null,
        'path' => null,
        'domain' => null,
        'secure' => false,
        'HTTPOnly' => false
    ];

    private $data;
    private $responseCode;


    public function __construct()
    {
        $this->data = self::$default;
    }

    /**
     * @param $name
     * @param int $maxage time in second, for example : 60 = 1min
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $HTTPOnly
     *
     * @return Cookie
     */
    public function createCookie( $name, int $maxage = 0, string $path = '', string $domain = '', bool $secure = false,bool $HTTPOnly = false): Cookie
    {
        $this->setName($name)
        ->setMaxage($maxage)
        ->setPath($path)
        ->setDomain($domain)
        ->setSecure($secure)
        ->setHTTPOnly($HTTPOnly);

        return $this->set();
    }

    public function set(): Cookie
    {
        $ob = ini_get('output_buffering');

        // Abort the method if headers have already been sent, except when output buffering has been enabled
        if (headers_sent() && false === (bool)$ob  || 'off' == strtolower($ob) ) {
            return $this;
        }

        // Prevent "headers already sent" error with utf8 support (BOM)
        //if ( utf8_support ) header('Content-Type: text/html; charset=utf-8');
        header('Set-Cookie: ' . $this->getName() . ";"
            . (empty($this->getDomain()) ? '' : '; Domain=' . $this->getDomain())
            . (empty($this->getMaxage()) ? '' : '; Max-Age=' . $this->getMaxage())
            . (empty($this->getPath()) ? '' : '; Path=' . $this->getPath())
            . (!$this->getSecure() ? '' : '; Secure')
            . (!$this->getHTTPOnly() ? '' : '; HttpOnly'), false, $this->getResponseCode());


        return $this;
    }

    /**
     * Get the value of maxage.
     */
    private function getMaxage() : int
    {
        return $this->data['maxage'];
    }

    /**
     * Set the value of maxage.
     *
     */
    public function setMaxage($maxage) : Cookie
    {
        if (!is_null($maxage)) {
            $maxage = intval($maxage);
            $this->data['maxage'] = 'Expires=' . date(DATE_COOKIE, $maxage > 0 ? time() + $maxage : 0) . 'Max-Age=' . $maxage;
        }
        $this->data['maxage'] = $maxage;
        return $this;

    }

    /**
     * Get the value of name.
     */
    private function getName() : string
    {
        return $this->data['name'];
    }

    /**
     * Set the value of name.
     *
     */
    public function setName($name) : Cookie
    {
        if(is_array($name)) {

            foreach ($name as $k => $v) {
                $this->data['name'] = $k . '=' . rawurlencode($v);
            }
        }else {
            $this->data['name'] = $name . '='. rawurlencode($name);
        }

        return $this;

    }

    /**
     * Get the value of path.
     */
    private function getPath() : string
    {
        return $this->data['path'];
    }

    /**
     * Set the value of path.
     *
     */
    public function setPath($path) : Cookie
    {
        $this->data['path'] = $path;
        return $this;

    }

    /**
     * Get the value of domain.
     */
    private function getDomain()
    {
        return $this->data['domain'];
    }

    /**
     * Set the value of domain.
     *
     */
    public function setDomain($domain)
    {

        if (!empty($domain)) {
            // Fix the domain to accept domains with and without 'www.'.
            if (strtolower(substr($domain, 0, 4)) == 'www.') {
                $this->data['domain'] = substr($domain, 4);
            }

            // Add the dot prefix to ensure compatibility with subdomains
            if (substr($domain, 0, 1) != '.') {
                $this->data['domain'] = '.' . $domain;
            }
            // Remove port information.
            $port = strpos($domain, ':');
            if ( false !== $port ) {
                $this->data['domain'] = substr($domain, 0, $port);
            }
        }

        return $this;
    }

    /**
     * Get the value of secure.
     */
    private function getSecure() : bool
    {
        return $this->data['secure'];
    }

    /**
     * Set the value of secure.
     *
     */
    public function setSecure($secure) : Cookie
    {
        $this->data['secure'] = $secure;
        return $this;

    }

    /**
     * Get the value of HTTPOnly.
     */
    private function getHTTPOnly() : bool
    {
        return $this->data['HTTPOnly'];
    }

    /**
     * Set the value of HTTPOnly.
     *
     */
    public function setHTTPOnly($HTTPOnly) : Cookie
    {
        $this->data['HTTPOnly'] = $HTTPOnly;
        return $this;

    }

    /**
     * @return mixed
     */
    private function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    public function getValue()
    {
        return $this->data['value'];
    }

    public function setValue($value){
         $this->data['value']= $value;

    }

    private function validate()
    {
        echo $this->getName();
        // Names must not be empty, but can be 0
        $name = $this->getName();
        if (empty($name) && !is_numeric($name)) {
            return 'The cookie name must not be empty';
        }

        // Check if any of the invalid characters are present in the cookie name
        if (preg_match(
            '/[\x00-\x20\x22\x28-\x29\x2c\x2f\x3a-\x40\x5c\x7b\x7d\x7f]/',
            $name
        )) {
            return 'Cookie name must not contain invalid characters: ASCII '
                . 'Control characters (0-31;127), space, tab and the '
                . 'following characters: ()<>@,;:\"/?={}';
        }

        // Value must not be empty, but can be 0
        $value = $this->getValue();
        if (empty($value) && !is_numeric($value)) {
            return 'The cookie value must not be empty';
        }

        // Domains must not be empty, but can be 0
        // A "0" is not a valid internet domain, but may be used as server name
        // in a private network.
        $domain = $this->getDomain();
        if (empty($domain) && !is_numeric($domain)) {
            return 'The cookie domain must not be empty';
        }

        return true;
    }
}
