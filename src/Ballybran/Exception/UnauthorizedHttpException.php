<?php

namespace Ballybran\Exception;

/**
 * Class UnauthorizedHttpException
 * Adapted from Laravel Framework in order to use HTTP Exceptions
 *
 * @package Knut7\Exception
 */
class UnauthorizedHttpException extends HttpException
{
    public function __construct(
        string $challenge,
        $message = null,
        \Exception $previous = null,
        ?int $code = 0,
        array $headers = []
    ) {
        $headers['WWW-Authenticate'] = $challenge;

        parent::__construct(401, $message, $previous, $headers, $code);
    }
}
