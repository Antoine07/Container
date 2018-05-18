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
     * @return mixed
     */
    public function singleton(string $key)
    {
        static $o;
        static $serviceKey;


        if (!isset($this->services[$key]) or !is_callable($this->services[$key]))
            throw new \InvalidArgumentException(\sprintf('service not found or not callable : %s', $key));

        if (is_null($o) or $key !== $serviceKey) {
            $o = $this->services[$key]($this);
            $serviceKey = $key;

            return $o;
        }

        return $o;
    }

    // à tester pour voir si ça marche !!!! J'attends vos retour
    public function asShared(\Closure $callable)
    {
        return function ($c) use ($callable) {
            static $o;
            if (is_null($o)) {
                $o = $callable($c);
            }
            return $o;
        };
    }

}