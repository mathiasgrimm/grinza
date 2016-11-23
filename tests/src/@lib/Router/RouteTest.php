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
        $route = new Grinza\Router\Route(null);

        $route->setName('name');
        $route->setAction('Controller@method');
        $route->setHttpMethod('httpMethod');
        $route->setPattern('pattern');

        $this->assertEquals('name'              , $route->getName());
        $this->assertEquals('Controller@method' , $route->getAction());
        $this->assertEquals('httpMethod'        , $route->getHttpMethod());
        $this->assertEquals('pattern'           , $route->getPattern());
    }

    /**
     * @test
     */
    public function setAction_validates()
    {
        $error = 'Action must be either a string (controller@method) or a closure';
        $route = new Grinza\Router\Route(null);
        $route->setAction('Controller@method');
        $route->setAction(function () {});
        
        

        try {
            $route->setAction([]);
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals($error, $e->getMessage());

        $e = null;
        try {
            $route->setAction('');
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals($error, $e->getMessage());

        $e = null;
        try {
            $route->setAction(new stdClass());
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals($error, $e->getMessage());

        $e = null;
        try {
            $route->setAction(123);
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals($error, $e->getMessage());

        $e = null;
        try {
            $route->setAction('controller');
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals($error, $e->getMessage());
    }

    /**
     * @test
     */
    public function constructor_sets_variables_correctly()
    {
        $name       = 'index.show';
        $httpMethod = 'GET';
        $pattern    = '/index';
        $action     = 'App\\Controllers\\SomeController@show';

        $route = new Route($name, $httpMethod, $pattern, $action);

        $this->assertEquals($name       , $route->getName());
        $this->assertEquals($httpMethod , $route->getHttpMethod());
        $this->assertEquals($pattern    , $route->getPattern());
        $this->assertEquals($action     , $route->getAction());
    }

    /**
     * @test
     */
    public function it_gets_named_params_when_they_exist()
    {
        $name       = 'index.show';
        $httpMethod = 'GET';
        $pattern    = '/{locale}/user/{id}';
        $action     = 'App\\Controllers\\SomeController@show';

        $route = new Route($name, $httpMethod, $pattern, $action);
        $this->assertEquals(['locale', 'id'], $route->getNamedParams());
    }

    /**
     * @test
     */
    public function it_gets_null_when_there_is_no_named_params()
    {
        $name       = 'index.show';
        $httpMethod = 'GET';
        $pattern    = '/{user';
        $action     = 'App\\Controllers\\SomeController@show';

        $route = new Route($name, $httpMethod, $pattern, $action);
        $this->assertNull($route->getNamedParams());
    }

    /**
     * @test
     */
    public function isActionClosure_works()
    {
        $r = new Route();
        $this->assertFalse($r->isActionClosure());
        $this->assertFalse($r->isActionClosure('asd'));
        $this->assertFalse($r->isActionClosure('asd@asd'));

        $r->setAction('controller@method');
        $this->assertFalse($r->isActionClosure());

        $this->assertTrue($r->isActionClosure(function () {}));

        $r->setAction(function () {});
        $this->assertTrue($r->isActionClosure());
    }

    /**
     * @test
     */
    public function isActionMethod_works()
    {
        $r = new Route();
        $r = new Route();
        $this->assertFalse($r->isActionMethod());
        $this->assertFalse($r->isActionMethod(function () {}));

        $r->setAction(function () {});
        $this->assertFalse($r->isActionMethod());

        $this->assertTrue($r->isActionMethod('controller@method'));

        $r->setAction('controller@method');
        $this->assertTrue($r->isActionMethod());
    }
}