<?php
/**
 *
 * KNUT7 K7F (http://framework.artphoweb.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (http://framework.artphoweb.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      http://github.com/zebedeu/artphoweb for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (http://www.artphoweb.com)
 * @license   http://framework.artphoweb.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.7
 *
 *
 */


namespace Ballybran\Helpers\Log;


/**
 * Class Logger
 * @package Ballybran\Helpers\Log
 */
class Logger
{

    /**
     * @var
     */
    protected $file;

    /**
     * @var
     */
    protected $content;

    /**
     * @var int
     */
    protected $writeFlag;

    /**
     * @var string
     */
    protected $endRow;

    /**
     * @var
     */
    private $newRow;


    /**
     * Logger constructor.
     * @param $file
     * @param string $endRow
     * @param int $writeFlag
     */
    public function __construct($file, $endRow = "\n", $writeFlag = FILE_APPEND)
    {

        $this->file = DIR_LOGS . $file;

        $this->writeFlag = $writeFlag;

        $this->endRow = $endRow;
        $this->newRow;

    }

    /**
     * @param string $content
     * @param int $newLines
     * @return $this
     */
    public function AddRow($content = "", $newLines = 1)
    {

        for ($m = 0; $m < $newLines; $m++) {
            $this->newRow .= $this->endRow;

        }
        $this->content .= $content . $this->newRow;

        return $this;

    }


    /**
     * @return $this
     */
    public function Commit()
    {
        file_put_contents($this->file, $this->content, $this->writeFlag);

        return $this;
    }

    /**
     * @return $this
     */
    public function getCommit()
    {
        file_get_contents($this->file, $this->content);

        return $this;

    }

    /**
     * @param $error
     * @param int $newLines
     */
    public function LogError($error, $newLines = 1)
    {
        if ($error != "") {

            $this->AddRow($error, $newLines);
            echo $error;

        }

    }

}
