<?php

namespace Ballybran\Facades;

use Closure;
use Ballybran\Kernel\Facade;

/**
 * @method static any(string $route, string|Closure $callback, array $options = [])
 * @method static get(string $route, string|Closure $callback, array $options = [])
 * @method static post(string $route, string|Closure $callback, array $options = [])
 * @method static put(string $route, string|Closure $callback, array $options = [])
 * @method static delete(string $route, string|Closure $callback, array $options = [])
 * @method static patch(string $route, string|Closure $callback, array $options = [])
 * @method static head(string $route, string|Closure $callback, array $options = [])
 * @method static options(string $route, string|Closure $callback, array $options = [])
 * @method static ajax(string $route, string|Closure $callback, array $options = [])
 * @method static xget(string $route, string|Closure $callback, array $options = [])
 * @method static xpost(string $route, string|Closure $callback, array $options = [])
 * @method static xput(string $route, string|Closure $callback, array $options = [])
 * @method static xdelete(string $route, string|Closure $callback, array $options = [])
 * @method static xpatch(string $route, string|Closure $callback, array $options = [])
 * @method static add(string $methods, string $route, string|Closure $callback, array $options = [])
 * @method static controller(string $route, string $controller, array $options = [])
 * @method static group(string $route, Closure $callback, array $options = [])
 * @method static pattern(array|string $name, $pattern = null)
 * @method static getRoutes()
 *
 * @see \Ballybran\Router\Route
 */
class Route extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'route';
    }
}