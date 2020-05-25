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


namespace Ballybran\Helpers;


use Ballybran\Helpers\Security\Http;

/**
 * Class Url
 * @package Ballybran\Helpers
 */
class Url extends Http
{

    private $url;

    public function __construct(bool $url = false)
    {
        //$this->url = $url;
        parent::__construct($url);

    }

    public function getUrl()
    {
        return $this->url();

    }
}
