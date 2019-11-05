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

namespace Ballybran\Helpers\Log;


/**
 * Class Log
 * @package Ballybran\Helpers\Log
 */
class Log
{

    /**
     * @var
     */
    private $handle;
    /**
     * @var
     */
    private $filename;
    /**
     * @var
     */
    private $handles;

    /**
     *
     * @param type $filename
     * @param null $dir
     */
    public function __construct($filename, $dir = null)
    {

        if ($dir != null) {

            $this->filename = $dir . $filename;

        } else {

            $this->filename = DIR_LOGS . $filename;
        }
    }

    /**
     *
     * @param type $message
     * @param null $type
     */
    public function write($message, $type = null)
    {
        if ($this->handle = fopen($this->filename, 'a')) {
            if (is_array($message) && $type === 'A') {
                foreach ($message as $key => $value) {
                    fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($key . " -> " . $value, true) . "\n");

                }
            }
            if (!empty($message)) {
                fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");

            }
            // to use for get data

            if (is_array($message) && $type == 'F') {
                foreach ($message as $key => $value) {
                    fwrite($this->handle, date('Y-m-d G:i:s') . ';' . print_r($key . "=>" . $value, true) . "\n") . "<br>";

                }
            }
        }
        fclose($this->handle);
        if ($this->filename == true) {
            chmod($this->filename, 0755);
        }
    }

    /**
     *
     */
    public function open()
    {
        if (file_exists($this->filename) && is_readable($this->filename) && $this->handles = fopen($this->filename, 'r')) {
            require_once DIR_FILE . 'View/header.phtml';
            ?>
            <div class="well">
                <ul>
                    <?php
                    while (!feof($this->handles)) {
                        $content = fgets($this->handles);

                        if (trim($content) != "") {
                            echo "<li style='color: blue'>$content</li>";
                        }
                    } ?>

                </ul>
            </div>
            <?php
            fclose($this->handles);

        } else {
            echo "Could not read from {$this->filename}";
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->filename;
    }

    /**
     *
     * @param type $files
     * @return type
     */
    public function Files($files)
    {
        return $this->files = $files;
    }

}
