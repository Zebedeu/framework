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

namespace Ballybran\Core\Http\Client;

use \Ballybran\Core\Http\Encodes;
use Ballybran\Helpers\Http\Http;

class ClientRest extends Encodes
{

    private $cookies;
    private $headers = [];
    private $user_agent;
    private $compression;
    private $cookie_file;
    private $proxy;

    function __construct($cookies = true, $cookie = "", $compression = 'gzip', $proxy = '')
    {
        $this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $this->headers[] = 'Connection: Keep-Alive';
        $this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $this->user_agent = Http::http_user_agent();
        $this->compression = $compression;
        $this->proxy = $proxy;
        $this->cookies = $cookies;
        if ($this->cookies == true) {
            $this->cookie($cookie);
        }

    }

    private function cookie($cookie_file)
    {
        if (file_exists($cookie_file)) {
                $this->cookie_file = $cookie_file;
        } else {
            fopen($cookie_file, 'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
            $this->cookie_file = $cookie_file;
            fclose($cookie_file);
        }
    }

    public function get($url, $fields = null, $httpheader = null)
    {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $httpheader);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == true) {
            curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        }
        if ($this->cookies == true) {
            curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        }
        curl_setopt($process, CURLOPT_ENCODING, $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) {
            curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        }
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);


        // Close the cURL resource, and free system resources
        curl_close($process);
        $decoded = json_decode($return);

        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        if (json_last_error() === JSON_ERROR_NONE) {
            //if not joson, is xml'
            return ($decoded);

        } else {
            // if json true, return json
            return ($return);

        }

    }

    public function post($url, $data, $httpheader = null )
    {
        $process = curl_init($url);
        if(null == $httpheader){
            $httpheader = $this->headers;
        }
        curl_setopt($process, CURLOPT_HTTPHEADER, $httpheader);
        // curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == true) {
            curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        }
        if ($this->cookies == true) {
            curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        }
        curl_setopt($process, CURLOPT_ENCODING, $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) {
            curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        }
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }



    public function put($url = '', array $data)
    {
//        'http://example.com/api/conversations/cid123/status'
        $process = curl_init($url);

        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_CUSTOMREQUEST, "PUT");
        $data = array("status" => 'R');
        curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($process);
        if (false === $response) {
            $info = curl_getinfo($process);
            curl_close($process);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($process);
        $decoded = json_decode($response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        echo 'response ok!';
        return ($decoded->response);
    }

    public function delete($value = '')
    {
//        'http://example.com/api/conversations/[CONVERSATION_ID]'
        $service_url = $value;
        $process = curl_init($service_url);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($service_url));
        $curl_response = curl_exec($process);
        if (false === $curl_response) {
            $info = curl_getinfo($process);
            curl_close($process);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($process);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        echo 'response ok!';
        return ($decoded->response);
    }

    function error($error)
    {
        echo "<center><div style='width:500px;border: 3px solid #FFEEFF; padding: 3px; background-color: #FFDDFF;font-family: verdana; font-size: 10px'><b>cURL Error</b><br>$error</div></center>";
        die;
    }
}
