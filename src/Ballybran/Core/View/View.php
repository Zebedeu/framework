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
 *
 *   Includes - Ability to include other views
 *
 *   Captures - Ability to easily capture content within your view
 *
 *   Layouts - Ability to inject data into a re-usable layout template
 *
 *   Fetching - Ability to fetch view output instead of sending it to output buffer
 *
 *   data - Ability to access the resulting data once the view is finished
 *
 * *NOTE* When a view uses a layout, the output of the view is ignored, as
 *        as the view is expected to use capture() to send data to the layout.
 * @property  UserData propriedade gerada e usada para pegar dados do model
 */

namespace Ballybran\Core\View;

use Ballybran\Core\Collections\Collection\IteratorDot;
use Ballybran\Helpers\Security\RenderFiles;
use \Ballybran\Helpers\Event\Registry;

class View extends RenderFiles implements ViewrInterface, \ArrayAccess
{
    public string $view;
    public array $data = array();
    protected string $controllers;
    private Form $form;
    private Registry $reg;

    public function __construct()
    {
        $this->reg = Registry::getInstance();
        $this->data;
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
    public function render(object $controller, string $view): string
    {
        $this->dot = new IteratorDot($this->get_data());

        $data = (null === $this->get_data()) ? array() : $this->get_data();
        $this->view = $view;
        $remove_namespace = explode('\\', get_class($controller));
        $this->controllers = $remove_namespace[3];
        extract($this->get_data());
        ob_start();
        $this->isHeader();

        include $this->file = VIEW . $this->controllers . DS . $this->view . $this->ex;
        $this->isFooter();

        $content = ob_get_contents();
        return $content;
    }


    public function fetch($data = null)
    {
        ob_start();
        $this->render($this->controllers, $this->view, $data);

        return ob_get_clean();
    }

    public function merge(array $data) : void
    {
        $this->data = \array_merge($this->data, $data);

    }

    public function get_data() : array
    {
        return $this->data;
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

    public function offsetExists($offset) : bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset) : string
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value) : void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset) : void
    {
        unset($this->data[$offset]);
    }
}
