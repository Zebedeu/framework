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
use Ballybran\Helpers\Event\Registry;
use Ballybran\Helpers\vardump\Vardump;

/**
 * Class Model
 * @package Ballybran\Core\Model
 */
class Model
{

    /**
     * @var
     */
    private $modelClass;
    /**
     * @var
     */
    public $model;

    /**
     * @var string
     */
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


    /**
     * @return mixed
     */
    public function getLoadModel() {

       $className = str_replace( '\\', '/', get_class($this));
       $classModel = str_replace('Controllers','Models', $className);


        $this->modelClass = $classModel . 'Model';

        $path =  $this->modelClass . '.php';

        if (file_exists($path)  || is_readable($path)) {
            require_once $path;

            return $this->dbObject();
        }


    }

    /**
     * @return mixed
     */
    private function dbObject()
    {

        $registry = RegistryDatabase::getInstance();
        $obj = $registry->get(TYPE);
        $className = str_replace('/', '\\', $this->modelClass);
        return $this->model = new $className($obj);
    }

}