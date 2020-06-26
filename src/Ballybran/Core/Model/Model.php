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
    public $modelPath = 'Models';

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

    /**
     * @return mixed
     */


    private function getLoadModel()
    {
        $className = str_replace('\\', '/', get_class($this));
        $classModel = str_replace('Controllers', $this->modelPath, $className);
        $this->modelClass = $classModel . 'Model';
        //$path = 'App/' . $this->modelClass . '.php';  // Use when bootstrap route is enabled
        $path = $this->modelClass . '.php';
        if (file_exists($path) || is_readable($path)) {
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
        $this->obj = $registry->get(TYPE);
        $className = str_replace('/', '\\', $this->modelClass);

        $this->model = new $className($this->obj);

            $this->model;
    }

}
