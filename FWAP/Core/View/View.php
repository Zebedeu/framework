<?php

/**
 *
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
/**
 * @property  UserData propriedade gerada e usada para pegar dados do model
 */

namespace FWAP\Core\View;



use FWAP\Exception\Exception;
use FWAP\Helpers\Security\iRenderFiles;
use FWAP\Helpers\Security\RenderFiles;

class View extends RenderFiles implements iView
{

    private $view;

    /**
     * @param $controller $this responsavel para pegar a pasta da View
     * @param $view Index responsavel em pegar  os arquivos Index da pasta do controller
     */
    private $controllers;
    /**
     * @var iRenderFiles
     */
    private $files;

    /**
     * @param $controller
     * @param String|NULL $view
     * @return bool|void
     */


    public function render($controller, String $view )
    {
        $this->view = $view;
        $this->controllers = get_class($controller);

        return $this->init();

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


