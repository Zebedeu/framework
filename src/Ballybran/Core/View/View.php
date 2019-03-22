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
/**
 * @property  UserData propriedade gerada e usada para pegar dados do model
 */

namespace Ballybran\Core\View;

use Ballybran\Core\Collections\Collection\IteratorDot;
use Ballybran\Helpers\Security\RenderFiles;

class View extends RenderFiles implements ViewrInterface, \ArrayAccess
{
    public $view;
    public $data = array();
    public $layout;
    /**
     * @param $Controller $this responsavel para pegar a pasta da View
     * @param $view Index responsavel em pegar  os arquivos Index da pasta do Controller
     */
    private $controllers;

    public function set($id)
    {
        $this->data[] = \array_merge($this->data, $id);
    }

    /**
     * render.
     *
     * @param mixed $controller
     * @param mixed $view
     * @param mixed $data
     *
     * @return string
     */
    public function render(object $controller, String $view, array $data = null): string
    {
        $this->dot = new IteratorDot($data);

        $this->data[] = (null === $data) ? array() : $data;
        $this->view = $view;
        $remove_namespace = explode('\\', get_class($controller));
        $this->controllers = $remove_namespace[2];
        extract($this->data);
        ob_start();
        $this->isHeader();
        include $this->file = DIR_FILE.'Views/'.$this->controllers.DS.$this->view.$this->ex;
        $this->isFooter();
        if (null === $this->layout) {
            ob_end_flush();
        } else {
            ob_end_clean();
            $this->include_file($this->layout);
        }
        $content = ob_get_contents();

        return $content;
    }

    public function fetch($data = null)
    {
        ob_start();
        $this->render($this->controllers, $this->view, $data);

        return ob_get_clean();
    }

    public function get_data()
    {
        return $this->data;
    }

    protected function include_file($file)
    {
        $view = new View($file);
        $view->render($this->controllers, $this->view, $this->data);
        $this->data[] = $view->get_data();
    }

    protected function set_layout($file)
    {
        $this->layout = $file;
    }

    protected function capture()
    {
        ob_start();
    }

    protected function end_capture($name)
    {
        $this->data[$name] = ob_get_clean();
    }

    private function init(): bool
    {
        $this->isViewPath($this->controllers);
        $this->isIndex($this->controllers, $this->view);

        return true;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
