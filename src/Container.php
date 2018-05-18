<?php namespace App;

class Container
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @param mixed $k
     * @param mixed $v | callable
     */
    public function set($k, $v)
    {
        if (isset($this->services[$k])) {
            throw new \RuntimeException(\sprintf('Cannot override frozen service "%s".', $k));
        }

        $this->services[$k] = $v;
    }

    /**
     * @param mixed $k
     * @return mixed
     */
    public function get($k)
    {
        if (!isset($this->services[$k]))
            throw new \InvalidArgumentException(\sprintf('service not found : %s', $k));

        if (is_callable($this->services[$k]))
            return $this->services[$k]($this);

        return $this->services[$k];
    }

    /**
     * @param string $key
     * @param \Closure $callable
     * @return \Closure
     */
    public function singleton(string $key, \Closure $callable)
    {

    }

}