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

class RouterCommand
{
    /**
     * @var RouterCommand|null Class instance variable
     */
    protected static $instance = null;

    protected $baseFolder;
    protected $paths;
    protected $namespaces;

    /**
     * RouterCommand constructor.
     *
     * @param $baseFolder
     * @param $paths
     * @param $namespaces
     */
    public function __construct($baseFolder, $paths, $namespaces)
    {
        $this->baseFolder = $baseFolder;
        $this->paths = $paths;
        $this->namespaces = $namespaces;
    }

    public function getMiddlewareInfo()
    {
        return [
            'path' => $this->baseFolder . '/' . $this->paths['middlewares'],
            'namespace' => $this->namespaces['middlewares'],
        ];
    }

    public function getControllerInfo()
    {
        return [
            'path' => $this->baseFolder . '/' . $this->paths['controllers'],
            'namespace' => $this->namespaces['controllers'],
        ];
    }

    /**
     * @param $baseFolder
     * @param $paths
     * @param $namespaces
     *
     * @return RouterCommand|static
     */
    public static function getInstance($baseFolder, $paths, $namespaces)
    {
        if (null === self::$instance) {
            self::$instance = new static($baseFolder, $paths, $namespaces);
        }
        return self::$instance;
    }

    /**
     * Throw new Exception for Router Error
     *
     * @param $message
     *
     * @return RouterException
     * @throws
     */
    public function exception($message = '')
    {
        return new RouterException($message);
    }

    /**
     * Run Route Middlewares
     *
     * @param $command
     *
     * @return mixed|void
     * @throws
     */
    public function beforeAfter($command, $request, $response)
    {
        if (!is_null($command)) {
            $info = $this->getMiddlewareInfo();
            if (is_array($command)) {
                foreach ($command as $value) {
                    $this->beforeAfter($value, $request, $response);
                }
            } elseif (is_string($command)) {
                $middleware = explode(':', $command);
                $params = [];
                $params[] = $request;
                $params[] = $response;
                if (count($middleware) > 1) {
                    $params = explode(',', $middleware[1]);

                }
                $controller = $this->resolveClass($middleware[0], $info['path'], $info['namespace']);
                if (method_exists($controller, 'handle')) {
                     $return =  call_user_func_array([$controller, 'handle'], $params);
                     if($return != true) {
                          echo $return;
                          exit;

                        } else {
                         return $return;
                     }
                    }

                return $this->exception('handle() method is not found in <b>' . $command . '</b> class.');
            }
        }

        return;
    }

    /**
     * Run Route Command; Controller or Closure
     *
     * @param $command
     * @param $params
     *
     * @return mixed|void
     * @throws
     */
    public function runRoute($command, $params = null)
    {
        $info = $this->getControllerInfo();
        if (!is_object($command)) {
            $segments = explode('@', $command);
            $controllerClass = str_replace([$info['namespace'], '\\', '.'], ['', '/', '/'], $segments[0]);
            $controllerMethod = $segments[1];

            $controller = $this->resolveClass($controllerClass, $info['path'], $info['namespace']);
            if (method_exists($controller, $controllerMethod)) {
                echo $this->runMethodWithParams([$controller, $controllerMethod], $params);
                return;
            }

            return $this->exception($controllerMethod . ' method is not found in ' . $controllerClass . ' class.');
        } else {
            echo $this->runMethodWithParams($command, $params);
        }

        return;
    }

    /**
     * Resolve Controller or Middleware class.
     *
     * @param $class
     * @param $path
     * @param $namespace
     *
     * @return object
     * @throws
     */
    protected function resolveClass($class, $path, $namespace)
    {
        $file = realpath(rtrim($path, '/') . '/' . $class . '.php');
        if (!file_exists($file)) {
            return $this->exception($class . ' class is not found. Please, check file.');
        }

        $class = $namespace . str_replace('/', '\\', $class);
        if (!class_exists($class)) {
            require_once($file);
        }

        return new $class();
    }

    /**
     * @param $function
     * @param $params
     *
     * @return mixed
     */
    protected function runMethodWithParams($function, $params)
    {
        return call_user_func_array($function, (!is_null($params) ? $params : []));
    }
}
