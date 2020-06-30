<?php

namespace Ballybran\Core\Http\Middleware\Exception;
use Throwable;

class InvalidArgumentException extends InvalidArgumentException {

    public const ERROR_MESSAGE = 'The middleware is not a valid %s and is not passed in the Container. Given: %s';

    /**
     * @var mixed|null 
     */
    private $invalidMiddleware;

    public function __construct( $invalidMiddleware = null, $code = 0, Throwable $previous = null )
    {
        $message = \sprintf(self::ERROR_MESSAGE, MiddlewareInterface::class, $this->castStageToString($invalidMiddleware));
        parent::__construct( $message, $code, $previous);
        $this->invalidMiddleware = $invalidMiddleware;
    }

    /**
     *  return the invalid middleware
     * @return mixed|null
     */
    public function getInvalidMiddleware(){
        return $this->invalidMiddleware;
    }
    private function castStageToString(string $stage) : string{
        
        if(\is_scalar($stage)){
            return (string) $stage;
        }

        if(\is_scalar($stage)){
            return \json_encode($stage) ?: 'array';
        }
        
        if(\is_object($stage)){
            return \get_class($stage) ?: 'array';
        }

        return \json_encode($stage) ?: 'Closure';
        
    }

}