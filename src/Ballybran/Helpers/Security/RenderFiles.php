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

namespace Ballybran\Helpers\Security;

use Closure;
use Ballybran\Exception\KException;

class RenderFiles
{
    protected $index = 'index';
    protected $header = 'header';
    protected $footer = 'footer';
    protected $ex = '.phtml';

    public function __construct()
    {
        $this->ex;
    }

    protected function isViewPath($controller)
    {
        if (!file_exists(VIEW) || !is_readable(VIEW)) {
            return KException::noPathView();
        }

        if (!is_readable(VIEW . $controller) || !file_exists(VIEW . $controller)) {
            return KException::noPathinView($controller);
        }
    }

    protected function isHeader()
    {
        if (!file_exists(VIEW . $this->header . $this->ex) || !is_readable(VIEW . $this->header . $this->ex)) {
            return KException::notHeader();
        }
        require_once VIEW . $this->header . $this->ex;
    }

    protected function isFooter()
    {
        if (!is_readable(VIEW . $this->footer . $this->ex) || !file_exists(VIEW . $this->footer . $this->ex)) {
            return KException::notFooter();
        }

        require_once VIEW . $this->footer . $this->ex;
    }

    public function isIndex($controller, $view, $data = null)
    {
        require_once VIEW . $controller . DS . $view . $this->ex;

    }
}
