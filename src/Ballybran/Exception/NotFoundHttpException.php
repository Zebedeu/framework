<?php

namespace Ballybran\Exception;

/**
 * Class NotFoundHttpException
 * Adapted from Laravel Framework in order to use HTTP Exceptions
 *
 * @package Knut7\Exception
 */
class NotFoundHttpException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(404, $message, $previous, $headers, $code);
    }
}