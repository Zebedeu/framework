<?php
/**
 * APWEB Framework (http://framework.artphoweb.com/)
 * APWEB FW(tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2016.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */



namespace FWAP\Helpers\Security;


class RenderFiles implements iRenderFiles
{
    private $index = "index.phtml";
    private $header = "header.phtml";
    private $footer = "footer.phtml";
    private $ex = '.phtml';

    public function isViewPath($controllers) {
        if (!file_exists(VIEW) || !is_readable(VIEW)) {
            return Exception::noPathView();
        }

        if (!is_readable(VIEW . $controllers) || !file_exists(VIEW . $controllers)) {
            return Exception::noPathinView($controllers);
        }

    }
    public function isHeader(){


        if (!file_exists(VIEW . $this->header) || !is_readable(VIEW . $this->header)) {
            return Exception::notHeader();
        }
        require_once VIEW . $this->header;

    }
    public function isFooter() {

        if (!is_readable(VIEW . $this->footer) || !file_exists(VIEW . $this->footer)) {
            return Exception::notFooter();
        }

        require_once VIEW . $this->footer;
    }

    public function isIndex($controllers, $view)
    {

        if (!is_readable(VIEW . $controllers . DS . $view . $this->ex) || !file_exists(VIEW . $controllers . DS . $view . $this->ex)) {
            return Exceptio::notIndex($controllers);
        }
        require_once VIEW . $controllers . DS . $view . $this->ex;
    }

}