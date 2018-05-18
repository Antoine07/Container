<?php namespace Tests;

use App\Container;
use App\Services\Foo;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private $container;

    public function setUp(){
        $this->container = new Container();
    }

    public function testInitContainer(){
        $this->assertInstanceOf(
            Container::class, $this->container
        );
    }

    public function testAddService(){
        $this->container->set('Foo', function($c){
            return new \App\Services\Foo();
        });

        $this->assertInstanceOf(
            Foo::class, $this->container->get('Foo')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage service not found : BadService
     */
    public function testExceptionServiceNotFound(){
        $this->container->get('BadService');
    }
}