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
 * @copyright (c) 2015.  APWEB  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.0
 */
/**
 * @property  UserData propriedade gerada e usada para pegar dados do model
 */

namespace Ballybran\Core\View;

use Ballybran\Core\Variables\Variable;
use Ballybran\Exception\Exception;
use Ballybran\Helpers\Security\RenderFilesrInterface;
use Ballybran\Helpers\Security\RenderFiles;
use Ballybran\Helpers\vardump\Vardump;
use function extract;
use function get_class;
use function get_class_methods;
use function is_array;
use function str_replace;
use function str_split;

class View extends RenderFiles implements ViewrInterface
{

    private $view;

    /**
     * @param $Controller $this responsavel para pegar a pasta da View
     * @param $view Index responsavel em pegar  os arquivos Index da pasta do Controller
     */
    private $controllers;
    /**
     * @var array
     */
    public $data;


    public function __construct($key= null, $value = null)
    {
        $this->data;
        if (!is_null($key)) {
            if (is_array($key)) {
                extract($key, EXTR_PREFIX_SAME, "");
            } else {
                ${$key} = $value;
                return $this->data = ${$key};
            }

        }

        return $this;
    }

    /**
     * @param $Controller
     * @param String|NULL $view
     * @return bool|void
     */

    public function render($controller, String $view)
    {
        $this->view = $view;
       $remove_namespace = explode( '\\', get_class($controller));
        $this->controllers = $remove_namespace[3];
        $this->init();




    }

    private function init() : bool
    {

        $this->isViewPath($this->controllers);
        $this->isHeader();
        $this->isIndex($this->controllers, $this->view);
        $this->isFooter();

        return true;


    }

   }


