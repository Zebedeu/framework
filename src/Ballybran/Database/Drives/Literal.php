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
 * User: macbookpro
 * Date: 16/11/17
 * Time: 10:34
 */

namespace Ballybran\Database\Drives;


class Literal
{

    /**
     * Literal constructor.
     * @param string $value
     */


    function __construct($value)
    {

        $this->value = $value;

    }

    /**
     * Return the literal value
     *
     * @return string
     */
    function __toString()
    {

        return $this->value;

    }

    /** @var string */
    public $value;

}
