<?php

namespace App\Services;

class Baz
{
    private $config ;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig(){
        return $this->config;
    }
}