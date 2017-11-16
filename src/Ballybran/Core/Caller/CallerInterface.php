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


namespace Ballybran\Core\Caller;


use Ballybran\Helpers\vardump\Vardump;
use function str_replace;

/**
 * CallerInterface Caller
 * @package Ballybran\Core\Caller
 */
interface CallerInterface
{

    /**
     * @param $funcname
     * @param array $args
     * @return mixed
     */
    function __call($funcname, $args = array());

    /**
     * Caller constructor.
     * @param bool $callerClassName
     * @param string $callerModuleName
     */
    function __construct($callerClassName = false, $callerModuleName = 'Webboard');

    /**
     *
     */
    function __destruct();
    /**
     * @param $isset
     * @return bool
     */
    function __isset($isset);

    /**
     * @param $unset
     */
    function __unset($unset);

    /**
     * @param $set
     * @param $val
     */
    function __set($set, $val);

    /**
     * @param $get
     * @return bool
     */
    function __get($get);

    /**
     *
     */
    function setModuleInformation();

    /**
     *
     */
    function unsetModuleInformation();

}