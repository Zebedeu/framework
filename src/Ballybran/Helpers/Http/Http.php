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

namespace Ballybran\Helpers\Security;
/**
 * Class Http
 * @package Ballybran\Helpers\Security
 */
class Http {

	private $securite;
    private $url;
    public function __construct($securite){
         $this->securite = $securite;

    }
    public function url()
    {
        if ($this->securite == true) {
            return $this->url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF'])) . DIRECTORY_SEPARATOR;
        }

        return $this->url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\');

    }
}