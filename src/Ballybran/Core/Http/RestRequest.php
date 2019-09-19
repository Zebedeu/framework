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

namespace Ballybran\Core\Http;

class RestRequest
{
    private $request_vars;
    private $data;
    private $http_accept;
    private $method;
    protected $_url;

    public function __construct()
    {
        $this->request_vars = array();
        $this->data    = '';
        $this->http_accept = (strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
        $this->method    = 'get';
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setRequestVars($request_vars)
    {
        $this->request_vars = $request_vars;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHttpAccept()
    {
        return $this->http_accept;
    }

    public function getRequestVars()
    {
        return $this->request_vars;
    }

    /**
     * Fetches the $_GET from 'url'.
     */
    public function getUri()
    {

        $url = $_GET['url'] ?? 'index';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }


}