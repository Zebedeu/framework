<?php

namespace Ballybran\Exception;

/**
 * Class BadRequestHttpException
 * Adapted from Laravel Framework in order to use HTTP Exceptions
 *
 * @package Knut7\Exception
 */
class BadRequestHttpException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(400, $message, $previous, $headers, $code);
    }
}
