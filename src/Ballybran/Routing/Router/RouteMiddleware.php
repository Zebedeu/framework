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
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.14
 *
 *
 */

namespace Ballybran\Routing\Router;

class RouteMiddleware {

    /**
     * @var array $middlewares General middlewares for per request
     */
    protected $middlewares = [];

    /**
     * @var array $routeMiddlewares Route middlewares
     */
    protected $routeMiddlewares = [];

    /**
     * @var array $middlewareGroups Middleware Groups
     */
    protected $middlewareGroups = [];

    /**
     * [TODO] This method implementation not completed yet.
     *
     * Set route middleware
     *
     * @param string|array $middleware
     * @param string $type
     *
     * @return $this
     */
    public function middleware($middleware, $type = 'before')
    {
        if (!is_array($middleware) && !is_string($middleware)) {
            return $this;
        }

        $currentRoute = end($this->routes);
        $currentRoute[$type] = $middleware;
        array_pop($this->routes);
        array_push($this->routes, $currentRoute);

        return $this;
    }

    /**
     * [TODO] This method implementation not completed yet.
     *
     * @param string|array $middleware
     *
     * @return $this
     */
    public function middlewareBefore($middleware)
    {
        $this->middleware($middleware, 'before');

        return $this;
    }

    /**
     * [TODO] This method implementation not completed yet.
     *
     * @param string|array $middleware
     *
     * @return $this
     */
    public function middlewareAfter($middleware)
    {
        $this->middleware($middleware, 'after');

        return $this;
    }

    /**
     * [TODO] This method implementation not completed yet.
     *
     * Set general middlewares
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setMiddleware(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * [TODO] This method implementation not completed yet.
     *
     * Set Route middlewares
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setRouteMiddleware(array $middlewares)
    {
        $this->routeMiddlewares = $middlewares;
    }

    /**
     * [TODO] This method implementation not completed yet.
     *
     * Set middleware groups
     *
     * @param array $middlewareGroup
     *
     * @return void
     */
    public function setMiddlewareGroup(array $middlewareGroup)
    {
        $this->middlewareGroups = $middlewareGroup;
    }


    /**
     * Set paths and namespaces for Controllers and Middlewares.
     *
     * @param array $params
     *
     * @return void
     */
    protected function setPaths($params)
    {
        if (empty($params)) {
            return;
        }

        if (isset($params['paths']) && $paths = $params['paths']) {
            $this->paths['controllers'] = isset($paths['controllers'])
                ? trim($paths['controllers'], '/')
                : $this->paths['controllers'];

            $this->paths['middlewares'] = isset($paths['middlewares'])
                ? trim($paths['middlewares'], '/')
                : $this->paths['middlewares'];
        }

        if (isset($params['namespaces']) && $namespaces = $params['namespaces']) {
            $this->namespaces['controllers'] = isset($namespaces['controllers'])
                ? trim($namespaces['controllers'], '\\') . '\\'
                : '';

            $this->namespaces['middlewares'] = isset($namespaces['middlewares'])
                ? trim($namespaces['middlewares'], '\\') . '\\'
                : '';
        }

        if (isset($params['base_folder'])) {
            $this->baseFolder = rtrim($params['base_folder'], '/');
        }

        if (isset($params['main_method'])) {
            $this->mainMethod = $params['main_method'];
        }

        $this->cacheFile = isset($params['cache']) ? $params['cache'] : realpath(__DIR__ . '/../cache.php');
    }

    /**
     * @param $controller
     *
     * @return RouterException|mixed
     */
    protected function resolveClass($controller)
    {
        $controller = str_replace(['\\', '.'], '/', $controller);
        $controller = trim(
            preg_replace(
                '/' . str_replace('/', '\\/', $this->paths['controllers']) . '/i',
                '', $controller,
                1
            ),
            '/'
        );
        $file = realpath(rtrim($this->paths['controllers'], '/') . '/' . $controller . '.php');

        if (!file_exists($file)) {
            return $this->exception($controller . ' class is not found!');
        }

        $controller = $this->namespaces['controllers'] . str_replace('/', '\\', $controller);
        if (!class_exists($controller)) {
            require $file;
        }

        return $controller;
    }

    /**
     * Routes error function. (Closure)
     *
     * @param $callback
     *
     * @return void
     */
    public function error($callback)
    {
        $this->errorCallback = $callback;
    }

    /**
     * Display all Routes.
     *
     * @return void
     */
    public function getList()
    {
        echo '<pre>';
        var_dump($this->getRoutes());
        echo '</pre>';
        die;
    }

    /**
     * Get all Routes
     *
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->routes;
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
     * RouterCommand class
     *
     * @return RouterCommand
     */
    public function routerCommand()
    {
        return RouterCommand::getInstance($this->baseFolder, $this->paths, $this->namespaces);
    }

    /**
     * Cache all routes
     *
     * @return bool
     * @throws Exception
     */
    public function cache()
    {
        foreach ($this->getRoutes() as $key => $r) {
            if (!is_string($r['callback'])) {
                throw new \Exception(sprintf('Routes cannot contain a Closure/Function callback while caching.'));
            }
        }

        $cacheContent = '<?php return ' . var_export($this->getRoutes(), true) . ';' . PHP_EOL;
        if (false === file_put_contents($this->cacheFile, $cacheContent)) {
            throw new \Exception(sprintf('Routes cache file could not be written.'));
        }

        return true;
    }

    /**
     * Load Cache file
     *
     * @return bool
     */
    protected function loadCache()
    {
        if (file_exists($this->cacheFile)) {
            $this->routes = require $this->cacheFile;
            $this->cacheLoaded = true;
            return true;
        }

        return false;
    }


}