<?php
/**
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.2
 */


namespace Ballybran\Helpers\Utility;


use ErrorException;

/**
 * Class ImportClass
 * Imports Pattern - Extend Classes in Real Time:
 * @package Ballybran\Helpers\Utility
 */
class ImportClass
{

    /**
     * @var array
     */
    var $__imported;
    /**
     * @var array
     */
    var $__imported_functions;

    /**
     * ImportClass constructor.
     */
    function __construct()
    {
        $this->__imported = Array();
        $this->__imported_functions = Array();
    }

    /**
     * @param $object
     */
    function Imports($object)
    {
        $new_imports = $object;
        $imports_name = get_class($new_imports);
        array_push($this->__imported, Array($imports_name, $new_imports));
        $imports_function = get_class_methods($new_imports);
        foreach ($imports_function as $i => $function_name) {
            $this->__imported_functions[$function_name] = &$new_imports;
        }
    }

    /**
     * @param $method
     * @param $array
     * @return mixed
     * @throws ErrorException
     */
    function __call($method, $array)
    {
        if (array_key_exists($method, $this->__imported_functions)) {
            return call_user_func_array(Array($this->__imported_functions[$method], $method), $array);
        }
        throw new ErrorException ('Call to Undefined Method/Class Function', 0, E_ERROR);
    }
}