<?php
/**
 *
 * KNUT7 K7F (https://marciozebedeu.com/)
 * KNUT7 K7F (tm) : Rapid Development Framework (https://marciozebedeu.com/)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link      https://github.com/knut7/framework/ for the canonical source repository
 * @copyright (c) 2015.  KNUT7  Software Technologies AO Inc. (https://marciozebedeu.com/)
 * @license   https://marciozebedeu.com/license/new-bsd New BSD License
 * @author    Marcio Zebedeu - artphoweb@artphoweb.com
 * @version   1.0.7
 *
 *
 */

namespace Ballybran\Core\Http;

/**
 * Pipeline class for passing an object through a series of pipes.
 */

use Closure;

class Pipeline
{
    /**
     * The object being passed through the pipeline.
     *
     * @var mixed
     */
    protected $passable;

    /**
     * The array of pipes.
     *
     * @var array
     */
    protected $pipes = [];

    /**
     * The additional parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The method to call on each pipe.
     *
     * @var string
     */
    protected $method = 'handle';

    /**
     * Set the object being sent through the pipeline.
     *
     * @param mixed $passable
     * @return $this
     */
    public function send($passable): self
    {
        $this->passable = $passable;

        return $this;
    }

    /**
     * Set the array of pipes.
     *
     * @param array $pipes
     * @return $this
     */
    public function through(array $pipes): self
    {
        $this->pipes = $pipes;

        return $this;
    }

    /**
     * Set the method to call on the pipes.
     *
     * @param string $method
     * @return $this
     */
    public function via(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set the additional parameters to send.
     *
     * @param array $parameters
     * @return $this
     */
    public function with(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Run the pipeline with a final destination callback.
     *
     * @param Closure $destination
     * @return mixed
     */
    public function process(Closure $destination)
    {
        $pipeline = array_reduce(
            array_reverse($this->pipes),
            $this->carry(),
            $this->prepareDestination($destination)
        );

        return $pipeline($this->passable);
    }

    /**
     * Get the final piece of the Closure onion.
     *
     * @param Closure $destination
     * @return Closure
     */
    protected function prepareDestination(Closure $destination): Closure
    {
        return function ($passable) use ($destination) {
            return $destination($passable);
        };
    }

    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return Closure
     */
    protected function carry(): Closure
    {
        return function ($stack, $pipe): Closure {
            return function ($passable) use ($stack, $pipe): mixed {
                $passable = array_merge([$passable, $stack], $this->parameters);

                if (is_callable($pipe)) {
                    return $pipe($passable);
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
     * Parse full pipe string to get name and parameters.
     *
     * @param string $pipe
     * @return array
     */
    protected function parsePipeString(string $pipe): array
    {
        list($name, $parameters) = array_pad(explode(':', $pipe, 2), 2, []);

        if (is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }

        return [$name, $parameters];
    }
}