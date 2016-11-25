<?php

use Grinza\Router\Route;
use Grinza\Router\RouteCollection;

class RouteCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_works_with_nulls()
    {
        new RouteCollection();
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function validate_works_when_all_attributes_exist()
    {
        $routes = new RouteCollection();
        $routes->addRoute(new Route(null, ['GET'], '/user', 'UserController@index'));
        $this->assertCount(1, $routes->getRoutes());
    }

    /**
     * @test
     */
    public function validate_works_when_any_required_attribute_is_missing()
    {
        $routes = new RouteCollection();

        try {
            $routes->addRoute(new Route(null, [], '/user', 'UserController@index'));
            $this->fail();
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals('Route does not have httpMethod and therefore cant be added', $e->getMessage());

        try {
            $routes->addRoute(new Route(null, ['GET'], null, 'UserController@index'));
            $this->fail();
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals('Route does not have pattern and therefore cant be added', $e->getMessage());

        try {
            $routes->addRoute(new Route(null, ['GET'],'/user', null, 'index'));
            $this->fail();
        } catch (\InvalidArgumentException $e) {}

        $this->assertEquals('Route does not have an action and therefore cant be added', $e->getMessage());
    }

    /**
     * @test
     */
    public function add_routes_works()
    {
        $routes = new RouteCollection();

        $routes->addRoutes([
            $r1 = new Route(null, ['GET'], '/user'      , 'UserController@index'),
            $r2 = new Route(null, ['GET'], '/user/{id}' , 'UserController@show'),
        ]);

        $values = array_values($routes->getRoutes()['GET']);

        $this->assertSame($r1, $values[0]);
        $this->assertSame($r2, $values[1]);
    }

    /**
     * @test
     */
    public function constructor_sets_correctly()
    {
        $routes = new RouteCollection([
            $r1 = new Route(null, ['GET'], '/user'      , 'UserController@index'),
            $r2 = new Route(null, ['GET'], '/user/{id}' , 'UserController@show'),
        ]);

        $values = array_values($routes->getRoutes()['GET']);

        $this->assertSame($r1, $values[0]);
        $this->assertSame($r2, $values[1]);
    }

    /**
     * @test
     */
    public function delete_works_when_route_has_name()
    {
        $routes = new RouteCollection([
            $r1 = new Route('user.index' , ['GET'] , '/user'      , 'UserController@index'),
            $r2 = new Route('user.show'  , ['GET'] , '/user/{id}' , 'UserController@show'),
        ]);

        $routes->deleteRoute($r1);

        $values = array_values($routes->getRoutes()['GET']);
        $this->assertCount(1, $values);
        $this->assertSame($r2, $values[0]);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function delete_works_when_route_has_no_name()
    {
        $routes = new RouteCollection([
            $r1 = new Route('user.index' , ['GET'], '/user'      , 'UserController@index'),
            $r2 = new Route('user.show'  , ['GET'], '/user/{id}' , 'UserController@show'),
        ]);

        $routes->deleteRoute(new Route());
        $this->fail();
    }

    /**
     * @test
     */
    public function after_deleting_all_routes_getRoutes_is_an_empty_array()
    {
        $routes = new RouteCollection([
            $r1 = new Route('user.index', ['GET'], '/user'      , 'UserController@index'),
            $r2 = new Route('user.show' , ['GET'], '/user/{id}' , 'UserController@show'),
        ]);

        $routes->deleteRoute($r1);
        $routes->deleteRoute($r2);

        $this->assertEquals([], $routes->getRoutes());
    }

    /**
     * @test
     */
    public function adding_same_route_twice_should_create_a_single_entry()
    {
        $r1 = new Route('user.index', ['GET'], '/user', 'UserController@index');

        $routes = new RouteCollection();
        $routes->addRoute($r1);
        $routes->addRoute($r1);

        $expected = [
            'GET' => [
                'user.index' => $r1
            ]
        ];

        $this->assertEquals($expected, $routes->getRoutes());

        // via constructor
        $routes = new RouteCollection([
            $r1,
            $r1
        ]);

        $this->assertEquals($expected, $routes->getRoutes());
    }

}