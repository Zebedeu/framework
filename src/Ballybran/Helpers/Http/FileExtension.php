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

/**
 * Created by PhpStorm.
 * User: artphotografie
 * Date: 11/08/17
 * Time: 14:11
 */

namespace Ballybran\Helpers\Http;


class FileExtension
{
    private $extension = array('php', 'phtml', 'html', 'inc', 'js', 'css');
    private $ex;

    public function __construct($obj)
    {

        $this->obj = $obj;
    }

    public function isIstension()
    {

        $extension = $this->obj->getExtension();

        foreach ($this->extension as $key => $value) {

            if ($value == $extension) {
                return true;
            }
            return false;
        }


    }


}

