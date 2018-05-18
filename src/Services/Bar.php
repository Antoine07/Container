<?php
namespace App\Services;

class Bar {

    private $baz;

    public function __construct(Baz $baz)
    {
        $this->baz = $baz;
    }
}