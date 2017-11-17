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


namespace Ballybran\Core\Model;


use Ballybran\Database\RegistryDatabase;
use Ballybran\Helpers\Event\Register;
use Ballybran\Helpers\vardump\Vardump;

class Model
{

    private $modelClass;
    public $model;
    private $db;
    public $modelPath = "/Models/";

    /**
     * @return string
     */

    /**
     * @return mixed
     */
    public function getModelPath()
    {
        return $this->modelPath;
    }


    public function getloadModel() {

       $className = str_replace( '\\', '/', get_class($this));
       $classModel = str_replace('Controllers','Models', $className);


        $this->modelClass = $classModel . 'Model';

        $path =  $this->modelClass . '.php';

        if (file_exists($path)  || is_readable($path)) {
            require_once $path;


            return $this->dbObject();
        }


    }

    private function dbObject()
    {

        $registry = RegistryDatabase::getInstance();
        $obj = $registry->get(TYPE);
        $className = str_replace('/', '\\', $this->modelClass);
        return $this->model = new $className($obj);
    }

}