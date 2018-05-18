<?php namespace App\Services;

class Foo
{
    static $count = 0;
    private $time;

    public function __construct()
    {
        $this->time = time();
    }

    public function get(){
        return $this->time;
    }
}