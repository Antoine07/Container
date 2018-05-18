<?php namespace Tests;

use App\Container;
use App\Services\Foo;
use App\Services\Baz;
use App\Services\SuperBar;
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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Cannot override frozen service "Foo"
     */
    public function testExceptionCannotOverrideFrozenService(){

        $this->container->set('Foo', function($c){
            return new \App\Services\Foo();
        });

        $this->container->set('Foo', function($c){
            return new \App\Services\Foo();
        });
    }

    public function testConfigurationService(){
        $this->container->set('baz.config', ['a' => 'A', 'b' => 'B']);

        $this->container->set('Baz', function($c){
            return new \App\Services\Baz($c->get('baz.config'));
        });

        $serviceBaz = $this->container->get('Baz');
        $this->assertInstanceOf(
            Baz::class, $serviceBaz
        );

        $this->assertArrayHasKey('a', $serviceBaz->getConfig());
        $this->assertArrayHasKey('b', $serviceBaz->getConfig());

        $this->assertEquals(['a' => 'A', 'b' => 'B'],$this->container->get('baz.config'));
        $this->assertEquals(['a' => 'A', 'b' => 'B'],$this->container->get('Baz')->getConfig());
    }

    public function testSuperBar(){

        $this->container->set('baz.config', ['a' => 'A', 'b' => 'B']);
        $this->container->set('Baz', function($c){
            return new \App\Services\Baz($c->get('baz.config'));
        });

        $this->container->set('Bar', function($c){
            return new \App\Services\Bar($c->get('Baz'));
        } );

        $this->container->set('superbar.config', ['a' => 'A']);

        $this->container->set('SuperBar', function($c){
            return  new \App\Services\SuperBar($c->get('Bar'), $c->get('Baz'), $c->get('superbar.config'));
        });

        $serviceSuperBar = $this->container->get('SuperBar');

        $this->assertInstanceOf(
            SuperBar::class, $serviceSuperBar
        );
    }

}