<?php
/**
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
 * @version   1.0.2
 */


namespace Ballybran\Helpers;
/**
 * Class Cache
 * @package Ballybran\Helpers
 */
class Cache {

    private $adaptor;

    public function __construct($adaptor, $expire = 3600) {
        
        $class = 'Ballybran\cache\\' . $adaptor;
        
        if(class_exists($class)){
            $this->adaptor = new $class($expire);
        }else {
            throw new \Exception('Error: Coult not load cache Adaptor' . $adaptor . 'cache!!');
        }
    }

    /**
     * @param $key
     * @return mixed
     */
	public function get($key) {
		return $this->adaptor->get($key);
	}

	public function set($key, $value) {
		return $this->adaptor->set($key, $value);
	}

	public function delete($key) {
		return $this->adaptor->delete($key);
	}
}
