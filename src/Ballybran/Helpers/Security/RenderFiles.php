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


use Ballybran\Exception\Exception;

class RenderFiles
{
    private $index = "index";
    private $header = "header";
    private $footer = "footer";
    private $ex = ".phtml";

    public function __construct()
    {
        $this->ex;
    }

    protected function isViewPath($controller)
    {
        if (!file_exists(VIEW) || !is_readable(VIEW)) {
            return Exception::noPathView();
        }

        if (!is_readable(VIEW . $controller) || !file_exists(VIEW . $controller)) {
            return Exception::noPathinView($controller);
        }

    }

    protected function isHeader()
    {


        if (!file_exists(VIEW . $this->header . $this->ex) || !is_readable(VIEW . $this->header . $this->ex)) {
            return Exception::notHeader();
        }
        require_once VIEW . $this->header . $this->ex;

    }

    protected function isFooter()
    {

        if (!is_readable(VIEW . $this->footer . $this->ex) || !file_exists(VIEW . $this->footer . $this->ex)) {
            return Exception::notFooter();
        }

        require_once VIEW . $this->footer . $this->ex;
    }

    protected function isIndex($controller, $view)
    {

        if (!is_readable(VIEW . $controller . DS . $view . $this->ex) || !file_exists(VIEW . $controller . DS . $view . $this->ex)) {

            return Exception::notIndex($controller);
        }
        require_once VIEW . $controller . DS . $view . $this->ex;
    }

}