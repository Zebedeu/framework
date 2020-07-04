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
 * @license   https://marciozebedeu.com/license/new-bsd MIT lIcense
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.14
 *
 *
 */

namespace Ballybran\Routing\Router;

use Ballybran\Core\Http\Request;
use Ballybran\Core\Http\Response;

class RouterRequest
{
    /**
     * @var string $validMethods Valid methods for Requests
     */
    public $validMethods = 'GET|POST|PUT|DELETE|HEAD|OPTIONS|PATCH|ANY|AJAX|XPOST|XPUT|XDELETE|XPATCH';

    /**
     * Request method validation
     *
     * @param string $data
     * @param string $method
     *
     * @return bool
     */
    public function validMethod($data, $method)
    {
        $valid = false;
        if (strstr($data, '|')) {
            foreach (explode('|', $data) as $value) {
                $valid = $this->checkMethods($value, $method);
                if ($valid) {
                    break;
                }
            }
        } else {
            $valid = $this->checkMethods($data, $method);
        }

        return $valid;
    }

    /**
     * Get the request method used, taking overrides into account
     *
     * @return string
     */
    public function getRequestMethod()
    {
        // Take the method as found in $_SERVER
        $method = $_SERVER['REQUEST_METHOD'];
        // If it's a HEAD request override it to being GET and prevent any output, as per HTTP Specification
        // @url http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4
        if ($method === 'HEAD') {
            ob_start();
            $method = 'GET';
        } elseif ($method === 'POST') {
            $headers = $this->getRequestHeaders();
            if (isset($headers['X-HTTP-Method-Override']) &&
                in_array($headers['X-HTTP-Method-Override'], ['PUT', 'DELETE', 'PATCH', 'OPTIONS', 'HEAD'])) {
                $method = $headers['X-HTTP-Method-Override'];
            } elseif (!empty($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            }
        }

        return $method;
    }

    /**
     * check method valid
     *
     * @param string $value
     * @param string $method
     *
     * @return bool
     */
    protected function checkMethods($value, $method)
    {
        if (in_array($value, explode('|', $this->validMethods))) {
            if ($this->isAjax() && $value === 'AJAX') {
                return true;
            }

            if ($this->isAjax() && strpos($value, 'X') === 0 && $method === ltrim($value, 'X')) {
                return true;
            }

            if (in_array($value, [$method, 'ANY'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check ajax request
     *
     * @return bool
     */
    protected function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
    }

    /**
     * Get all request headers
     *
     * @return array
     */
    protected function getRequestHeaders()
    {
        

        // Method getallheaders() not available: manually extract 'm
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_' || $name === 'CONTENT_TYPE' || $name === 'CONTENT_LENGTH') {
                $headerKey = str_replace(
                    [' ', 'Http'],
                    ['-', 'HTTP'],
                    ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))
                );
                $headers[$headerKey] = $value;
            }
        }

        return $headers;
    }

      /**
     * This static method will create a new Request object, based on the
     * current PHP request.
     */
    public static function getRequest(): Request
    {
        $serverArr = $_SERVER;

        if ('cli' === PHP_SAPI) {
            // If we're running off the CLI, we're going to set some default
            // settings.
            $serverArr['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
            $serverArr['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
        }

        $r = self::createFromServerArray($serverArr);
        $r->setBody(fopen('php://input', 'r'));
        $r->setPostData($_POST);

        return $r;
    }

    /**
     * Sends the HTTP response back to a HTTP client.
     *
     * This calls php's header() function and streams the body to php://output.
     */
    public static function sendResponse(Response $response)
    {
        header('HTTP/'.$response->getHttpVersion().' '.$response->getStatus().' '.$response->getStatusText());
        foreach ($response->getHeaders() as $key => $value) {
            foreach ($value as $k => $v) {
                if (0 === $k) {
                    header($key.': '.$v);
                } else {
                    header($key.': '.$v, false);
                }
            }
        }

        $body = $response->getBody();
        if (null === $body) {
            return;
        }

        if (is_callable($body)) {
            $body();

            return;
        }

        $contentLength = $response->getHeader('Content-Length');
        if (null !== $contentLength) {
            $output = fopen('php://output', 'wb');
            if (is_resource($body) && 'stream' == get_resource_type($body)) {
                if (PHP_INT_SIZE > 4) {
                    // use the dedicated function on 64 Bit systems
                    // a workaround to make PHP more possible to use mmap based copy, see https://github.com/sabre-io/http/pull/119
                    $left = (int) $contentLength;
                    // copy with 4MiB chunks
                    $chunk_size = 4 * 1024 * 1024;
                    stream_set_chunk_size($output, $chunk_size);
                    // If this is a partial response, flush the beginning bytes until the first position that is a multiple of the page size.
                    $contentRange = $response->getHeader('Content-Range');
                    // Matching "Content-Range: bytes 1234-5678/7890"
                    if (null !== $contentRange && preg_match('/^bytes\s([0-9]+)-([0-9]+)\//i', $contentRange, $matches)) {
                        // 4kB should be the default page size on most architectures
                        $pageSize = 4096;
                        $offset = (int) $matches[1];
                        $delta = ($offset % $pageSize) > 0 ? ($pageSize - $offset % $pageSize) : 0;
                        if ($delta > 0) {
                            $left -= stream_copy_to_stream($body, $output, min($delta, $left));
                        }
                    }
                    while ($left > 0) {
                        $copied = stream_copy_to_stream($body, $output, min($left, $chunk_size));
                        // stream_copy_to_stream($src, $dest, $maxLength) must return the number of bytes copied or false in case of failure
                        // But when the $maxLength is greater than the total number of bytes remaining in the stream,
                        // It returns the negative number of bytes copied
                        // So break the loop in such cases.
                        if ($copied <= 0) {
                            break;
                        }
                        $left -= $copied;
                    }
                } else {
                    // workaround for 32 Bit systems to avoid stream_copy_to_stream
                    while (!feof($body)) {
                        fwrite($output, fread($body, 8192));
                    }
                }
            } else {
                fwrite($output, $body, (int) $contentLength);
            }
        } else {
            file_put_contents('php://output', $body);
        }

        if (is_resource($body)) {
            fclose($body);
        }
    }

    /**
     * This static method will create a new Request object, based on a PHP
     * $_SERVER array.
     *
     * REQUEST_URI and REQUEST_METHOD are required.
     */
    public static function createFromServerArray(array $serverArray): Request
    {
        $headers = [];
        $method = null;
        $url = null;
        $httpVersion = '1.1';

        $protocol = 'http';
        $hostName = 'localhost';

        foreach ($serverArray as $key => $value) {
            switch ($key) {
                case 'SERVER_PROTOCOL':
                    if ('HTTP/1.0' === $value) {
                        $httpVersion = '1.0';
                    } elseif ('HTTP/2.0' === $value) {
                        $httpVersion = '2.0';
                    }
                    break;
                case 'REQUEST_METHOD':
                    $method = $value;
                    break;
                case 'REQUEST_URI':
                    $url = $value;
                    break;

                // These sometimes show up without a HTTP_ prefix
                case 'CONTENT_TYPE':
                    $headers['Content-Type'] = $value;
                    break;
                case 'CONTENT_LENGTH':
                    $headers['Content-Length'] = $value;
                    break;

                // mod_php on apache will put credentials in these variables.
                // (fast)cgi does not usually do this, however.
                case 'PHP_AUTH_USER':
                    if (isset($serverArray['PHP_AUTH_PW'])) {
                        $headers['Authorization'] = 'Basic '.base64_encode($value.':'.$serverArray['PHP_AUTH_PW']);
                    }
                    break;

                // Similarly, mod_php may also screw around with digest auth.
                case 'PHP_AUTH_DIGEST':
                    $headers['Authorization'] = 'Digest '.$value;
                    break;

                // Apache may prefix the HTTP_AUTHORIZATION header with
                // REDIRECT_, if mod_rewrite was used.
                case 'REDIRECT_HTTP_AUTHORIZATION':
                    $headers['Authorization'] = $value;
                    break;

                case 'HTTP_HOST':
                    $hostName = $value;
                    $headers['Host'] = $value;
                    break;

                case 'HTTPS':
                    if (!empty($value) && 'off' !== $value) {
                        $protocol = 'https';
                    }
                    break;

                default:
                    if ('HTTP_' === substr($key, 0, 5)) {
                        // It's a HTTP header

                        // Normalizing it to be prettier
                        $header = strtolower(substr($key, 5));

                        // Transforming dashes into spaces, and uppercasing
                        // every first letter.
                        $header = ucwords(str_replace('_', ' ', $header));

                        // Turning spaces into dashes.
                        $header = str_replace(' ', '-', $header);
                        $headers[$header] = $value;
                    }
                    break;
            }
        }

        if (null === $url) {
            throw new \InvalidArgumentException('The _SERVER array must have a REQUEST_URI key');
        }

        if (null === $method) {
            throw new \InvalidArgumentException('The _SERVER array must have a REQUEST_METHOD key');
        }
        $r = new Request($method, $url, $headers);
        $r->setHttpVersion($httpVersion);
        $r->setRawServerData($serverArray);
        $r->setAbsoluteUrl($protocol.'://'.$hostName.$url);

        return $r;
    }
    
}
