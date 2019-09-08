<?php
/**
 * KNUT7 K7F (http://framework.artphoweb.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (http://framework.artphoweb.com/).
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @see      http://github.com/zebedeu/artphoweb for the canonical source repository
 *
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 *
 * @version   1.0.2
 */

namespace Ballybran\Helpers\Http;


/**
 * Class Cookie.
 */
class Cookie
{

    private $name;
    private $maxage;
    private $path;
    private $domain;
    private $secure;
    private $HTTPOnly;

    /**
     * @param $name
     * @param int $maxage time in second, for example : 60 = 1min
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $HTTPOnly
     *
     * @return bool
     */
    public function createCookie($name , $maxage = 0 , $path = '' , $domain = '' , $secure = false , $HTTPOnly = false)
    {
        $this->setName($name);
        $this->setMaxage($maxage);
        $this->setPath($path);
        $this->setDomain($domain);
        $this->setSecure($secure);
        $this->setHTTPOnly($HTTPOnly);

        return $this->set();
    }

    public function set(): bool
    {
        $ob = ini_get('output_buffering');

        // Abort the method if headers have already been sent, except when output buffering has been enabled
        if (headers_sent() && (bool)$ob === false || strtolower($ob) == 'off') {
            return false;
        }


        // Prevent "headers already sent" error with utf8 support (BOM)
        //if ( utf8_support ) header('Content-Type: text/html; charset=utf-8');
        if (is_array($this->getName())) {
            foreach ($this->getName() as $k => $v) {
                header('Set-Cookie: ' . $k . '=' . rawurlencode($v)
                    . (empty($this->getDomain()) ? '' : '; Domain=' . $this->getDomain())
                    . (empty($this->getMaxage()) ? '' : '; Max-Age=' . $this->getMaxage())
                    . (empty($this->getPath()) ? '' : '; Path=' . $this->getPath())
                    . (!$this->getSecure() ? '' : '; Secure')
                    . (!$this->getHTTPOnly() ? '' : '; HttpOnly') , false);
            }
        } else {
            header('Set-Cookie: ' . rawurlencode($this->getName()) . '=' . rawurlencode($this->getName())
                . (empty($this->getDomain()) ? '' : '; Domain=' . $this->getDomain())
                . (empty($this->getMaxage()) ? '' : '; Max-Age=' . $this->getMaxage())
                . (empty($this->getPath()) ? '' : '; Path=' . $this->getPath())
                . (!$this->getSecure() ? '' : '; Secure')
                . (!$this->getHTTPOnly() ? '' : '; HttpOnly') , false);
        }

        return true;
    }

    /**
     * Get the value of maxage.
     */
    public function getMaxage()
    {
        return $this->maxage;
    }

    /**
     * Set the value of maxage.
     *
     */
    public function setMaxage($maxage)
    {
        if (!is_null($maxage)) {
            $maxage = intval($maxage);
            $this->maxage = 'Expires=' . date(DATE_COOKIE , $maxage > 0 ? time() + $maxage : 0) . 'Max-Age=' . $maxage;
        }
        $this->maxage = $maxage;

    }

    /**
     * Get the value of name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     *
     */
    public function setName($name)
    {
        $this->name = $name;

    }

    /**
     * Get the value of path.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path.
     *
     */
    public function setPath($path)
    {
        $this->path = $path;

    }

    /**
     * Get the value of domain.
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set the value of domain.
     *
     */
    public function setDomain($domain)
    {

        if (!empty($domain)) {
            // Fix the domain to accept domains with and without 'www.'.
            if (strtolower(substr($domain , 0 , 4)) == 'www.') {
                $this->domain = substr($domain , 4);
            }

            // Add the dot prefix to ensure compatibility with subdomains
            if (substr($domain , 0 , 1) != '.') {
                $this->domain = '.' . $domain;
            }
            // Remove port information.
            $port = strpos($domain , ':');
            if ($port !== false) {
                $this->domain = substr($domain , 0 , $port);
            }
        }


        return $this;
    }

    /**
     * Get the value of secure.
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * Set the value of secure.
     *
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;

    }

    /**
     * Get the value of HTTPOnly.
     */
    public function getHTTPOnly()
    {
        return $this->HTTPOnly;
    }

    /**
     * Set the value of HTTPOnly.
     *
     */
    public function setHTTPOnly($HTTPOnly)
    {
        $this->HTTPOnly = $HTTPOnly;

    }
}
