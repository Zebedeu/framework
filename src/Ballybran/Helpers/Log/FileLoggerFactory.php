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
 * @version   1.0.7
 */


namespace Ballybran\Helpers\Log;


class FileLoggerFactory implements iLoggerFactory{

    /**
     * @var string
     */
    private $filePath;
    private $dir;

    public function __construct(string $filePath, $dir= null)
    {
        if ($dir != null) {

            $this->filePath = $dir . $filePath;

        } else {

            $this->filePath = DIR_LOGS . $filePath;
        }
    }

    public function createLogger(): iLogger
    {
        return new \Ballybran\Helpers\Log\FileLogger($this->filePath);
    }
}
