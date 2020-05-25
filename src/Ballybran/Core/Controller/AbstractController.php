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

/**
 * @property
 */

namespace Ballybran\Core\Controller;

use Ballybran\Core\Model\Model;
use Ballybran\Core\View\View;
use Ballybran\Helpers\Utility\Language;
use Ballybran\Helpers\Security\Session;

class AbstractController extends Model implements AbstractControllerInterface
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var
     */
    protected $width;
    /**
     * @var
     */
    protected $height;
    /**
     * @var
     */
    protected $quality;
    /**
     * @var
     */
    protected $option;
    public $language;
    protected $reg;

    /**
     * AbstractController constructor.
     *  call method function  init
     * View view estancia a class view
     * call method LoadeModel();.
     */
    public function __construct()
    {
        parent::__construct();
        Session::init();

        $this->view = new View();
        $this->language = new Language();
        $this->reg = \Ballybran\Helpers\Event\Registry::getInstance();

    }
}
