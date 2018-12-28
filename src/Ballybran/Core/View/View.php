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
/**
 * @property  UserData propriedade gerada e usada para pegar dados do model
 */

namespace Ballybran\Core\View;
use Ballybran\Core\Collections\Collection\IteratorDot;
use Ballybran\Core\Variables\Variable;
use Ballybran\Exception\Exception;
use Ballybran\Helpers\Security\RenderFilesrInterface;
use Ballybran\Helpers\Security\RenderFiles;
use Ballybran\Helpers\vardump\Vardump;


class View extends RenderFiles implements ViewrInterface
{

    public $view;

    public $dot;
    /**
     * @param $Controller $this responsavel para pegar a pasta da View
     * @param $view Index responsavel em pegar  os arquivos Index da pasta do Controller
     */
    private $controllers;

    /**
     * @param $Controller
     * @param String|NULL $view
     * @return bool|void
     */


    public function render($controller, String $view, $data = null)
    {
        $this->dot = new IteratorDot($data);
        $this->view = $view;
        $remove_namespace = explode('\\', get_class($controller));
        $this->controllers = $remove_namespace[2];

        $this->init();
        return $this;

    }

    private function init(): bool
    {

        $this->isViewPath($this->controllers);
        $this->isHeader();
        $this->isIndex($this->controllers, $this->view);
        $this->isFooter();

        return true;

    }
}

