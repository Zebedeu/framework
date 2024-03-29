<?php

namespace Ballybran\Hash;

use RuntimeException;

/**
 * Class Argon2IdHash
 * Adapted from Laravel Framework
 * @see https://github.com/laravel/framework/tree/8.x/src/Illuminate/Hashing
 *
 * @package Knut7\Hash
 */
class Argon2IdHash extends ArgonHash
{
    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     *
     * @return bool
     */
    public function check(string $value, string $hashedValue): bool
    {
        if ($this->verifyAlgorithm && $this->info($hashedValue)['algoName'] !== 'argon2id') {
            throw new RuntimeException('This password does not use the Argon2id algorithm.');
        }

        if (strlen($hashedValue) === 0) {
            return false;
        }

        return password_verify($value, $hashedValue);
    }

    /**
     * Get the algorithm that should be used for hashing.
     *
     * @return int
     */
    protected function algorithm()
    {
        return PASSWORD_ARGON2ID;
    }
}
