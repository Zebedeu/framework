<?php

namespace Ballybran\Router;

use Ballybran\Exception\NotFoundHttpException;

class RouterException extends \Ballybran\Route\RouterException
{
    /**
     * Create Exception Class.
     *
     * @param string $message
     * @param int    $statusCode
     *
     * @return mixed
     */
    public function __construct(string $message, $statusCode = 500)
    {
        throw new NotFoundHttpException($message);
    }
}
