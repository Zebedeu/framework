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

namespace Ballybran\Helpers\Http\Client;

use \Ballybran\Core\Http\Encodes;

class ClientRest extends Encodes
{

    public function get($argm)
    {

        $ch = curl_init();

        // Now set some options (most are optional)

        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, $argm);

        // Set a referer
        curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");

        // User agent
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // Download the given URL, and return output
        $output = curl_exec($ch);

        // Close the cURL resource, and free system resources
        curl_close($ch);
        $decoded = json_decode($output);

        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        if (json_last_error() === JSON_ERROR_NONE) {
            //if not joson, is xml'
            return (($decoded));

        } else {
            // if json true, return json
            return (($output));

        }
    }


    /**
     * @param $url String
     * @param $fields array  ["id" => 1, "name"=> "Joe Doe"]
     */

    public function post(string $url, array $filds)
    {
        $service_url = $url;
        $curl = curl_init($service_url);
        $curl_post_data = $filds;


        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);
        if (false === $curl_response) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);

        echo 'response ok!';
        return ($curl_response);
    }

    public function put($value = '')
    {
//        'http://example.com/api/conversations/cid123/status'
        $service_url = $value;
        $ch = curl_init($service_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        $data = array("status" => 'R');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        if (false === $response) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        $decoded = json_decode($response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        echo 'response ok!';
        var_export($decoded->response);
    }

    public function delete($value = '')
    {
//        'http://example.com/api/conversations/[CONVERSATION_ID]'
        $service_url = $value;
        $ch = curl_init($service_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $curl_post_data = array(
            'note' => 'this is spam!',
            'useridentifier' => 'agent@example.com',
            'apikey' => 'key001'
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($ch);
        if (false === $curl_response) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($ch);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        echo 'response ok!';
        var_export($decoded->response);
    }
}