<?php

namespace Ballybran\Router;

use Ballybran\Route\Router as RouterProvider;

class Router extends RouterProvider
{
    /**
     * Throw new Exception for Router Error

     * @throws RouterException
     */
    protected function exception(string $message = '', int $statusCode = 500)
    {
        throw new RouterException($message, $statusCode);
    }

    /**
     * RouterCommand class
     *
     * @return RouterCommand
     */
    protected function routerCommand(): \Ballybran\Route\RouterCommand
    {
        return RouterCommand::getInstance(
            $this->baseFolder, $this->paths, $this->namespaces,
            $this->request(), $this->response(),
            $this->getMiddlewares()
        );
    }

    protected function resolveClassName(string $controller)
    {
        if (strstr($controller, '\\')) {
            return ($controller);
        }

        return (str_replace(['.', '/'], ['\\'], $this->namespaces['controllers'] . $controller));
    }
}
