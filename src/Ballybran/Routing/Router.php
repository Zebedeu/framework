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
namespace Ballybran\Routing;

use Ballybran\Core\Http\Response;
use Ballybran\Core\Http\Request;
use Ballybran\Routing\Router\RouterException;
use Ballybran\Routing\Router\RouteMiddleware;
use Closure;
use ReflectionMethod;

/**
 * Class Router
 *
 * @method $this any($route, $settings, $callback = null)
 * @method $this get($route, $settings, $callback = null)
 * @method $this post($route, $settings, $callback = null)
 * @method $this put($route, $settings, $callback = null)
 * @method $this delete($route, $settings, $callback = null)
 * @method $this patch($route, $settings, $callback = null)
 * @method $this head($route, $settings, $callback = null)
 * @method $this options($route, $settings, $callback = null)
 * @method $this xpost($route, $settings, $callback = null)
 * @method $this xput($route, $settings, $callback = null)
 * @method $this xdelete($route, $settings, $callback = null)
 * @method $this xpatch($route, $settings, $callback = null)
 *
 * @package Buki
 */
class Router extends RouteMiddleware
{
    /**
     * @var string
     */
    protected $documentRoot = '';

    /**
     * @var string
     */
    protected $runningPath = '';

    private $request;
    private $response;
    /**
     * @var string $baseFolder Pattern definitions for parameters of Route
     */
    protected $baseFolder;

    /**
     * @var array $routes Routes list
     */
    protected $routes = [];

    /**
     * @var array $groups List of group routes
     */
    protected $groups = [];

    /**
     * @var array $patterns Pattern definitions for parameters of Route
     */
    protected $patterns = [
        ':id' => '(\d+)',
        ':number' => '(\d+)',
        ':any' => '([^/]+)',
        ':all' => '(.*)',
        ':string' => '(\w+)',
        ':slug' => '([\w\-_]+)',
    ];

    /**
     * @var array $namespaces Namespaces of Controllers and Middlewares files
     */
    protected $namespaces = [
        'middlewares' => '',
        'controllers' => '',
    ];

    /**
     * @var array $path Paths of Controllers and Middlewares files
     */
    protected $paths = [
        'controllers' => 'Controllers',
        'middlewares' => 'Middlewares',
    ];

    /**
     * @var string $mainMethod Main method for controller
     */
    protected $mainMethod = 'main';

    /**
     * @var string $cacheFile Cache file
     */
    protected $cacheFile = null;

    /**
     * @var bool $cacheLoaded Cache is loaded?
     */
    protected $cacheLoaded = false;

    /**
     * @var Closure $errorCallback Route error callback function
     */
    protected $errorCallback;

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
     * Router constructor method.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct(array $params = [])
    {
        $this->documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
        $this->runningPath = realpath(getcwd());
        $this->baseFolder = $this->runningPath;

        if (isset($params['debug']) && is_bool($params['debug'])) {
            RouterException::$debug = $params['debug'];
        }
        $this->request = new Request();
        $this->response = new Response();

        $this->setPaths($params);
        $this->loadCache();
    }

    /**
     * [TODO] This method implementation not completed yet.
     *
     * Set route name
     *
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        if (!is_string($name)) {
            return $this;
        }

        $currentRoute = end($this->routes);
        $currentRoute['name'] = $name;
        array_pop($this->routes);
        array_push($this->routes, $currentRoute);

        return $this;
    }

    /**
     * Add route method;
     * Get, Post, Put, Delete, Patch, Any, Ajax...
     *
     * @param $method
     * @param $params
     *
     * @return mixed
     * @throws
     */
    public function __call($method, $params)
    {
        if ($this->cacheLoaded) {
            return true;
        }

        if (is_null($params)) {
            return false;
        }

        if (!in_array(strtoupper($method), explode('|', $this->request->validMethods))) {
            return $this->exception($method . ' is not valid.');
        }

        $route = $params[0];
        $callback = $params[1];
        $settings = null;

        if (count($params) > 2) {
            $settings = $params[1];
            $callback = $params[2];
        }

        if (strstr($route, ':')) {
            $route1 = $route2 = '';
            foreach (explode('/', $route) as $key => $value) {
                if ($value != '') {
                    if (!strpos($value, '?')) {
                        $route1 .= '/' . $value;
                    } else {
                        if ($route2 == '') {
                            $this->addRoute($route1, $method, $callback, $settings);
                        }

                        $route2 = $route1 . '/' . str_replace('?', '', $value);
                        $this->addRoute($route2, $method, $callback, $settings);
                        $route1 = $route2;
                    }
                }
            }

            if ($route2 == '') {
                $this->addRoute($route1, $method, $callback, $settings);
            }
        } else {
            $this->addRoute($route, $method, $callback, $settings);
        }
        return $this;
    }

    /**
     * Add new route method one or more http methods.
     *
     * @param string               $methods
     * @param string               $route
     * @param array|string|closure $settings
     * @param string|closure       $callback
     *
     * @return bool
     */
    public function add($methods, $route, $settings, $callback = null)
    {
        if ($this->cacheLoaded) {
            return true;
        }

        if (is_null($callback)) {
            $callback = $settings;
            $settings = null;
        }

        if (strstr($methods, '|')) {
            foreach (array_unique(explode('|', $methods)) as $method) {
                if (!empty($method)) {
                    call_user_func_array([$this, strtolower($method)], [$route, $settings, $callback]);
                }
            }
        } else {
            call_user_func_array([$this, strtolower($methods)], [$route, $settings, $callback]);
        }

        return true;
    }

    /**
     * Add new route rules pattern; String or Array
     *
     * @param string|array $pattern
     * @param null|string  $attr
     *
     * @return mixed
     * @throws
     */
    public function pattern($pattern, $attr = null)
    {
        if (is_array($pattern)) {
            foreach ($pattern as $key => $value) {
                if (in_array($key, array_keys($this->patterns))) {
                    return $this->exception($key . ' pattern cannot be changed.');
                }
                $this->patterns[$key] = '(' . $value . ')';
            }
        } else {
            if (in_array($pattern, array_keys($this->patterns))) {
                return $this->exception($pattern . ' pattern cannot be changed.');
            }
            $this->patterns[$pattern] = '(' . $attr . ')';
        }

        return true;
    }

    /**
     * Run Routes
     *
     * @return void
     * @throws
     */
    public function run()
    {
        $base = str_replace('\\', '/', str_replace($this->documentRoot, '', $this->runningPath));
        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if ($_SERVER['REQUEST_URI'] !== $_SERVER['PHP_SELF']) {
            $uri = str_replace(dirname($_SERVER['PHP_SELF']), '/', $uri);
        }

        if (($base !== $uri) && (substr($uri, -1) === '/')) {
            $uri = substr($uri, 0, (strlen($uri) - 1));
        }


        $uri = $this->clearRouteName($uri);
        $method = $this->request->getRequestMethod();
        
        $searches = array_keys($this->patterns);
        $replaces = array_values($this->patterns);
        $foundRoute = false;

        $routes = array_column($this->routes, 'route');

        // check if route is defined without regex
        if (in_array($uri, $routes)) {
            $currentRoute = array_filter($this->routes, function($r) use ($method, $uri) {

                return $this->request->validMethod($r['method'], $method) && $r['route'] === $uri;
            });

            if (!empty($currentRoute)) {
                $currentRoute = current($currentRoute);
                $foundRoute = true;
                $this->runRouteMiddleware($currentRoute, 'before',  $this->request, $this->response);
                $this->runRouteCommand($currentRoute['callback']);
                $this->runRouteMiddleware($currentRoute, 'after',  $this->request, $this->response);
            }
        } else {
            foreach ($this->routes as $data) {
                $route = $data['route'];
                if (strstr($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if ($this->request->validMethod($data['method'], $method)) {
                        $foundRoute = true;

                        $this->runRouteMiddleware($data, 'before',  $this->request, $this->response);

                        array_shift($matched);
                        $matched = array_map(function($value) {
                            return trim(urldecode($value));
                        }, $matched);

                        $this->runRouteCommand($data['callback'], $matched, $this->request);
                        $this->runRouteMiddleware($data, 'after',  $this->request, $this->response);
                        break;
                    }
                }
            }
        }

        // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
        if (strtoupper($_SERVER['REQUEST_METHOD']) === 'HEAD') {
            ob_end_clean();
        }

        if ($foundRoute === false) {
            if (!$this->errorCallback) {
                $this->errorCallback = function() {
                    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
                    return $this->exception('Route not found. Looks like something went wrong. Please try again.');
                };
            }
            call_user_func($this->errorCallback);
        }
    }

    /**
     * Routes Group
     *
     * @param string        $name
     * @param closure|array $settings
     * @param null|closure  $callback
     *
     * @return bool
     */
    public function group($settings = null, $callback = null, $name =null)
    {
        if ($this->cacheLoaded) {
            return true;
        }

        $group = [];
        $group['route'] = isset($name) ? $this->clearRouteName($name) : null;
        $group['before'] = $group['after'] = null;

        if (is_null($callback)) {
            $callback = $settings;
        } else {
            $group['before'][] = !isset($settings['before']) ? null : $settings['before'];
            $group['after'][] = !isset($settings['after']) ? null : $settings['after'];
        }

        $groupCount = count($this->groups);
        if ($groupCount > 0) {
            $list = [];
            foreach ($this->groups as $key => $value) {
                if (is_array($value['before'])) {
                    foreach ($value['before'] as $k => $v) {
                        $list['before'][] = $v;
                    }
                    foreach ($value['after'] as $k => $v) {
                        $list['after'][] = $v;
                    }
                }
            }

            if (!is_null($group['before'])) {
                $list['before'][] = $group['before'][0];
            }

            if (!is_null($group['after'])) {
                $list['after'][] = $group['after'][0];
            }

            $group['before'] = $list['before'];
            $group['after'] = $list['after'];
        }

        $group['before'] = array_values(array_unique((array)$group['before']));
        $group['after'] = array_values(array_unique((array)$group['after']));

        array_push($this->groups, $group);

        if (is_object($callback)) {
            call_user_func_array($callback, [$this]);
        }

        $this->endGroup();

        return true;
    }

    /**
     * Added route from methods of Controller file.
     *
     * @param string       $route
     * @param string|array $settings
     * @param null|string  $controller
     *
     * @return mixed
     * @throws
     */
    public function controller($route, $settings, $controller = null)
    {
        if ($this->cacheLoaded) {
            return true;
        }

        if (is_null($controller)) {
            $controller = $settings;
            $settings = [];
        }

        $controller = $this->resolveClass($controller);
        $classMethods = get_class_methods($controller);
        if ($classMethods) {
            foreach ($classMethods as $methodName) {
                if (!strstr($methodName, '__')) {
                    $method = 'any';
                    foreach (explode('|', $this->request->validMethods) as $m) {
                        if (stripos($methodName, strtolower($m), 0) === 0) {
                            $method = strtolower($m);
                            break;
                        }
                    }

                    $methodVar = lcfirst(preg_replace('/' . $method . '/i', '', $methodName, 1));
                    $methodVar = strtolower(preg_replace('%([a-z]|[0-9])([A-Z])%', '\1-\2', $methodVar));
                    $r = new ReflectionMethod($controller, $methodName);
                    $endpoints = [];
                    foreach ($r->getParameters() as $param) {
                        $pattern = ':any';
                        $typeHint = $param->hasType() ? $param->getType()->getName() : null;
                        if (in_array($typeHint, ['int', 'bool'])) {
                            $pattern = ':id';
                        } elseif (in_array($typeHint, ['string', 'float'])) {
                            $pattern = ':slug';
                        } elseif ($typeHint === null) {
                            $pattern = ':any';
                        } else {
                            continue;
                        }
                        $endpoints[] = $param->isOptional() ? $pattern . '?' : $pattern;
                    }

                    $value = ($methodVar === $this->mainMethod ? $route : $route . '/' . $methodVar);
                    $this->{$method}(
                        ($value . '/' . implode('/', $endpoints)),
                        $settings,
                        ($controller . '@' . $methodName)
                    );
                }
            }
            unset($r);
        }

        return true;
    }

    /**
     * Add new Route and it's settings
     *
     * @param $uri
     * @param $method
     * @param $callback
     * @param $settings
     *
     * @return void
     */
    private function addRoute($uri, $method, $callback, $settings)
    {
        $groupItem = count($this->groups) - 1;
        $group = '';
        if ($groupItem > -1) {
            foreach ($this->groups as $key => $value) {
                $group .= $value['route'];
            }
        }

        $path = dirname($_SERVER['PHP_SELF']);
        $path = $path === '/' || strpos($this->runningPath, $path) !== 0 ? '' : $path;

        if (strstr($path, 'index.php')) {
            $data = implode('/', explode('/', $path));
            $path = str_replace($data, '', $path);
        }

        $route = $path . $group . '/' . trim($uri, '/');
        $route = rtrim($route, '/');
        if ($route === $path) {
            $route .= '/';
        }
            $this->criateRoute($route, $groupItem, $method, $callback, $settings);
        }

        private function criateRoute($route, $groupItem, $method, $callback, $settings){
            $routeName = is_string($callback)
            ? strtolower(preg_replace(
                '/[^\w]/i', '/', str_replace($this->namespaces['controllers'], '', $callback)
            ))
            : null;
        $data = [
            'route' => $this->clearRouteName($route),
            'method' => strtoupper($method),
            'callback' => $callback,
            'name' => isset($settings['name']) ? $settings['name'] : $routeName,
            'before' => isset($settings['before']) ? $settings['before'] : null,
            'after' => isset($settings['after']) ? $settings['after'] : null,
            'group' => $groupItem === -1 ? null : $this->groups[$groupItem],
        ];

        array_push($this->routes, $data);
    
        }

    /**
     * Run Route Command; Controller or Closure
     *
     * @param $command
     * @param $params
     *
     * @return void
     */

    private function runRouteCommand($command, $params = null)
    {
        $this->routerCommand()->runRoute($command, $params);
    }

    /**
     * Routes Group endpoint
     *
     * @return void
     */
    private function endGroup()
    {
        array_pop($this->groups);
    }

        /**
         * Detect Routes Middleware; before or after
         *
         * @param $middleware
         * @param $type
         *
         * @return void
         */
    public function runRouteMiddleware($middleware, $type, $request, $response)
    {
        
        if ($type === 'before') {
            if (!is_null($middleware['group'])) {
                $this->routerCommand()->beforeAfter($middleware['group'][$type], $request, $response);
            }
            $this->routerCommand()->beforeAfter($middleware[$type], $request, $response);
        } else {
            $this->routerCommand()->beforeAfter($middleware[$type], $request, $response);
            if (!is_null($middleware['group'])) {
                $this->routerCommand()->beforeAfter($middleware['group'][$type], $request, $response);
            }
        }
    }

    /**
     * @param string $route
     *
     * @return string
     */
    private function clearRouteName($route = '')
    {
        $route = trim(str_replace('//', '/', $route), '/');
        return $route === '' ? '/' : "/{$route}";
    }
}
