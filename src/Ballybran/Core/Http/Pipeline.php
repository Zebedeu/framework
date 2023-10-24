<?php

namespace Ballybran\Core\Http;

use Closure;

class Pipeline 
{

    /**
     * O dado que será passado pelo pipeline.
     *
     * @var mixed
     */
    protected $passable;

    /**
     * Array com os pipes (callbacks) que serão executados.
     * 
     * @var array
     */
    protected $pipes = [];

    /**
     * Parâmetros adicionais que serão passados para os pipes.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * O método que será chamado em cada pipe.
     *
     * @var string
     */
    protected $method = 'handle';

    /**
     * Define o dado $passable que será processado.
     *
     * @param mixed $passable
     * @return Pipeline
     */    
    public function send(...$passable) : Pipeline
    {
        $this->passable = $passable;

        return $this;
    }

    /**
     * Define os pipes.
     *
     * @param array|mixed $pipes
     * @return Pipeline
     */
    public function through($pipes) : Pipeline
    {
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();

        return $this;
    }

    /**
     * Define o método a ser chamado em cada pipe.
     *
     * @param string $method
     * @return Pipeline
     */
    public function via(string $method) : Pipeline
    {
        $this->method = $method;
        
        return $this;
    }

    /**
     * Define parâmetros adicionais para os pipes.
     *
     * @param array $parameters
     * @return Pipeline
     */
    public function withParameters(array $parameters) : Pipeline 
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Executa o pipeline e retorna o resultado.
     *
     * @param Closure $destination
     * @return mixed
     */
    public function process(Closure $destination)
    {
        $pipeline = array_reduce(
            array_reverse($this->pipes), $this->carry(), $this->prepareDestination($destination)
        );
        
        return call_user_func_array($pipeline, $this->passable);
    }

    /**
     * Prepara o callable final que receberá o resultado dos pipes.
     *
     * @param Closure $destination
     * @return Closure
     */
    protected function prepareDestination(Closure $destination) : Closure
    {
        return function() use ($destination) {
            return call_user_func_array($destination, func_get_args());
        };
    }

    /**
     * Empilha os pipes, criando o "onion" de callables.
     *
     * @return Closure
     */
     
     /**
 * Constroi o "onion" de callables para a pipeline.
 *
 * @return Closure
*/
protected function carry(): Closure 
{
  return function(mixed $stack, mixed $pipe): Closure {
    
    return function(...$args) use($stack, $pipe): mixed {

      $passable = $args;

      $passable[] = $stack;

      $passable = array_merge($passable, $this->parameters);

      if (is_callable($pipe)) {

        return $pipe(...$passable);

      } elseif (is_string($pipe)) {

        [$name, $params] = $this->parsePipeString($pipe);

        $pipe = new $name();

        return $pipe->{$this->method}(...array_merge($passable, $params));

      } elseif (is_object($pipe)) {

        return $pipe->{$this->method}(...$passable);

      }

    };

  };

}
    /**
     * Constroi um pipe a partir de uma string de classe.
     *
     * @param string $pipe
     * @return Closure
     */
    protected function buildPipeFromString(string $pipe) : Closure
    {
        list($name, $params) = $this->parsePipeString($pipe);
        
        return function(...$args) use ($name, $params) {
            $instance = new $name;
            
            return $instance->{$this->method}(...array_merge($args, $params));
        };
    }

    /**
     * Chama o método do pipe com os argumentos informados.
     *
     * @param mixed $pipe
     * @param array $args
     * @return mixed
     */
    protected function callPipeMethod($pipe, ...$args)
    {
        return $pipe->{$this->method}(...$args);
    }

    /**
     * Parseia uma string de pipe em nome de classe e parâmetros.
     * 
     * @param string $pipe
     * @return array
     */
    protected function parsePipeString(string $pipe) : array
    {
        $pipe = explode(':', $pipe, 2);
        
        return array_pad($pipe, 2, []);
    }

}