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

/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 09/01/17
 * Time: 13:21
 */

namespace Ballybran\Core\Caller;


class ConfigModule
{

    public $module;

    public $test;

    function __construct()
    {
        print('Constructor will have no Module Information... Use __init() instead!<br />');
        print('--> '.print_r($this->module, 1).' <--');
        print('<br />');
        print('<br />');
        $this->test = '123';
    }

    function __init()
    {
        print('Using of __init()!<br />');
        print('--> '.print_r($this->module, 1).' <--');
        print('<br />');
        print('<br />');
    }

    function testFunction($test = false)
    {
        if ($test != false)
            $this->test = $test;
    }
}
