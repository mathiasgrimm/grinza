<?php

use Grinza\Router\Route;

class RouteTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_does_not_fail_with_nulls()
    {
        $route = new Grinza\Router\Route();
    }

    /**
     * @test
     */
    public function getters_and_setters_work()
    {
        $route = new Grinza\Router\Route();

        $route->setName('name');
        $route->setControllerMethod('controllerMethod');
        $route->setController('controller');
        $route->setHttpMethod('httpMethod');
        $route->setPattern('pattern');

        $this->assertEquals('name', $route->getName());
        $this->assertEquals('controllerMethod', $route->getControllerMethod());
        $this->assertEquals('controller', $route->getController());
        $this->assertEquals('httpMethod', $route->getHttpMethod());
        $this->assertEquals('pattern', $route->getPattern());
    }

    /**
     * @test
     */
    public function constructor_sets_variables_correctly()
    {
        $name             = 'index.show';
        $httpMethod       = 'GET';
        $pattern          = '/index';
        $controller       = 'App\\Controllers\\SomeController';
        $controllerMethod = 'show';

        $route = new Route($name, $httpMethod, $pattern, $controller, $controllerMethod);

        $this->assertEquals($name             , $route->getName());
        $this->assertEquals($httpMethod       , $route->getHttpMethod());
        $this->assertEquals($pattern          , $route->getPattern());
        $this->assertEquals($controller       , $route->getController());
        $this->assertEquals($controllerMethod , $route->getControllerMethod());
    }

    /**
     * @test
     */
    public function it_get_named_params_when_they_exist()
    {
        $name             = 'index.show';
        $httpMethod       = 'GET';
        $pattern          = '/{locale}/user/{id}';
        $pattern          = '/user';
        $controller       = 'App\\Controllers\\SomeController';
        $controllerMethod = 'show';

        $route = new Route($name, $httpMethod, $pattern, $controller, $controllerMethod);
//        pd($route->getNamedParams());
    }
}