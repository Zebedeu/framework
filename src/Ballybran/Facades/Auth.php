<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

/**
 * @method static bool check()
 * @method static bool guest()
 * @method static \Ballybran\Database\Model|null user()
 * @method static int|null id()
 * @method static bool validate(array $credentials = [])
 * @method static bool attempt(array $credentials = [], bool $remember = false)
 * @method static bool login(\Ballybran\Database\Model $user, bool $remember = false)
 * @method static bool loginUsingId(mixed $id, bool $remember = false)
 * @method static void logout()
 *
 * @see \Ballybran\Auth\Auth
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ballybran\Auth\Auth::class;
    }
}
