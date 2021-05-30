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

namespace Ballybran\Core\Model;

use Ballybran\Database\RegistryDatabase;
use Ballybran\Exception\KException;

/**
 * Class Model.
 */
abstract class Model
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
    public $modelPath = 'Models';

    /**
     * @var string
     */
    public $controller = 'Controllers';

    /**
     * @var string
     */
    private $obj;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->getLoadModel();
    }


    public function createClassModel(){
         $className = str_replace('\\', '/', get_class($this));
         $classModel = str_replace($this->controller, $this->modelPath, $className);
         $this->modelClass = $classModel . 'Model';

         return $this->modelClass;
       
    }

    /**
     * @return mixed
     */
  
    public function getLoadModel()
    {
        
        $path = $this->createClassModel() . '.php';
        if (file_exists($path) || is_readable($path)) {
            require_once $path;
            return $this->model =  $this->dbObject();
        }

    }

    /**
     * @return mixed
     */
    private function dbObject()
    {
        $registry = RegistryDatabase::getInstance();
        $this->obj = $registry->get(TYPE);
        $className = str_replace('/', '\\', $this->modelClass);

        return new $className($this->obj);
    }

}
