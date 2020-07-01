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
     * Detect Routes Middleware; before or after
     *
     * @param $middleware
     * @param $type
     *
     * @return void
     */
    public function runRouteMiddleware($middleware, $type)
    {
        if ($type === 'before') {
            if (!is_null($middleware['group'])) {
                $this->routerCommand()->beforeAfter($middleware['group'][$type]);
            }
            $this->routerCommand()->beforeAfter($middleware[$type]);
        } else {
            $this->routerCommand()->beforeAfter($middleware[$type]);
            if (!is_null($middleware['group'])) {
                $this->routerCommand()->beforeAfter($middleware['group'][$type]);
            }
        }
    }

}