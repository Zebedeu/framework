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
 * @property
 */

namespace FWAP\Core\Controller;


use FWAP\Core\View\iView;
use FWAP\Core\View\View;
use FWAP\Helpers\Uploads;
use FWAP\Library\Bootstrap;
use FWAP\Helpers\Language;
use FWAP\Library\Log;
use FWAP\Helpers\Security\Session;

/**
 * @property iView iView desacopolamento da View
 * @property iLanguage iLanguage desacopolamento da Language
 */
abstract class Controller implements iController {

    public $view;
    public $language;
    public $model;
    public $compo;
    private $db;
    public $log;
    public $imagem;
    public $getServiceLocator;
    public $route;


    /**
     * Controller constructor.
     *  call method function  init
     * View view estancia a class view
     * call method LoadeModel();
     */
    public function __construct( ) {

        Session::init();

        $this->view = new View();
        $this->language = new Language();
        $this->language->Load('Welcome');
        $this->imagem = new Uploads();

        $this->loadModel();
    }

    /**
     * LoadeModel to load  XModel
     */
    private function loadModel( $modelPath = '/Models/') {
        $model = get_class($this) . 'Model';
        $path = PV . APP . $modelPath . $model . '.php';
        if (file_exists($path)) {
            if (is_readable($path)) {
                require_once $path;

                    if(TYPE == "PDO"){
                        $this->db = new \FWAP\Database\Drives\DatabasePDO(DB_TYPE, DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
                    }
                    if(TYPE == "PDOO"){
                        $this->db = new \FWAP\Database\Drives\DatabasePDOO(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
                    }
                    if(TYPE == "MYSQLI"){
                        $this->db = new \FWAP\Database\Drives\DatabaseMysqli( DB_HOST, DB_USER,   DB_PASS, DB_NAME,DB_PORT);
                    }

                $this->model = new $model($this->db);
            }
        }

    }

}
