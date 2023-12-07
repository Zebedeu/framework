<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

/**
 * @method static string encode($payload, $key, $alg = 'HS256', $keyId = null, $head = null)
 * @method static object decode($jwt, $key, array $allowed_algs = [])
 * @method static string sign($msg, $key, $alg = 'HS256')
 * @method static int getLeeway()
 * @method static void setLeeway(int $leeway)
 *
 * @see \Ballybran\Auth\Jwt\Jwt
 */
class Jwt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ballybran\Auth\Jwt\Jwt::class;
    }
}
