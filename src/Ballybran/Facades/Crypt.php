<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

/**
 * @method static string encrypt(string $value, bool $serialize = true)
 * @method static string decrypt(string $payload, bool $unserialize = true)
 *
 * @see \Ballybran\Encryption\Encrypter
 */
class Crypt extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'encrypter';
    }
}