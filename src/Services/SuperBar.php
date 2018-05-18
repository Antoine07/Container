<?php

namespace App\Services;

class SuperBar
{
    protected $baz;
    protected $bar;
    protected $params = [];

    public function __construct(Bar $bar, Baz $baz, array $param = [])
    {
        $this->bar = $bar;
        $this->baz = $baz;
        $this->params = $param;
    }
    /**
     * @return array
     */
    public function getParams():array
    {
        return $this->params;
    }
}