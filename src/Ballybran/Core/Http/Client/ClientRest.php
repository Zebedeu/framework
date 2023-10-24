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

use GuzzleHttp\Client as GuzzleClient;

class ClientRest
{
    private $client;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    public function get($url, $options = [])
    {
        $response = $this->client->get($url, $options);

        return $response->getBody()->getContents();
    }

    public function post($url, $data = [], $options = [])
    {
        $response = $this->client->post($url, array_merge($options, [
            'form_params' => $data,
        ]));

        return $response->getBody()->getContents();
    }

    public function put($url, $data = [], $options = [])
    {
        $response = $this->client->put($url, array_merge($options, [
            'form_params' => $data,
        ]));

        return $response->getBody()->getContents();
    }

    public function delete($url, $options = [])
    {
        $response = $this->client->delete($url, $options);

        return $response->getBody()->getContents();
    }
}