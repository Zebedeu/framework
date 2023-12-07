<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

/**
 * @method static void rules(array $rules)
 * @method static void rule(string $field, string $label, string $rules, array $text = [])
 * @method static bool isValid(array $data = [])
 * @method static array errors()
 * @method static mixed sanitize()
 *
 * @see \Ballybran\Http\Validation
 */
class Validation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ballybran\Http\Validation::class;
    }
}