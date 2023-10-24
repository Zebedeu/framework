<?php
/**
 *
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
 * @version   1.0.14
 *
 *
 */

namespace Ballybran\Routing\Router;

use Exception;

class RouterException
{
    /**
     * @var bool $debug Debug mode
     */
    public static $debug = false;

    /**
     * Create Exception Class.
     *
     * @param string $message
     *
     * @param int    $statusCode
     *
     * @throws Exception
     */
    public function __construct(string $message, int $statusCode = 500)
    {
        http_response_code($statusCode);
        if (self::$debug) {
            throw new Exception($message, $statusCode);
        }
        die("<h2>Opps! An error occurred.</h2> {$message}");
    }
}
