<?php

use Grinza\Http\Request;
use Grinza\Router\Matcher;
use Grinza\Router\Route;
use Grinza\Router\RouteCollection;
use Grinza\Router\Router;

class RouterTest extends TestCase
{
    /**
     * @test
     */
    public function getters_and_setters_work()
    {
        $routes  = new RouteCollection();
        $matcher = new Matcher();

        $router = new Router();
        $router->setMatcher($matcher);
        $router->setRouteCollection($routes);

        $this->assertSame($routes, $router->getRouteCollection());
        $this->assertSame($matcher, $router->getMatcher());
    }

    /**
     * @test
     */
    public function default_constructor_works()
    {
        new Router();
    }

    /**
     * @test
     */
    public function constructor_sets_variables()
    {
        $routes  = new RouteCollection();
        $matcher = new Matcher();

        $router = new Router($routes, $matcher);

        $this->assertSame($routes, $router->getRouteCollection());
        $this->assertSame($matcher, $router->getMatcher());
    }

    /**
     * @test
     */
    public function it_matches_a_match()
    {
        $routes  = new RouteCollection([
            $r1 = new Route('user.show'   , ['GET']    , '/user/{id}'      , 'UserController@show'),
            $r2 = new Route('user.edit'   , ['GET']    , '/user/{id}/edit' , 'UserController@edit'),
            $r3 = new Route('user.delete' , ['DELETE'] , '/user/{id}/'     , 'UserController@delete'),
        ]);

        $matcher = new Matcher();

        $router = new Router($routes, $matcher);

        $request = new Request([
            'REQUEST_URI'    => '/user/1',
            'REQUEST_METHOD' => 'GET'
        ]);

        $match = $router->match($request);

        $this->assertEquals(['id' => 1], $match->getParams());
        $this->assertSame($r1, $match->getRoute());
    }

    /**
     * @test
     */
    public function it_can_add_and_delete_routes()
    {
        $routes  = new RouteCollection([
            $r1 = new Route('user.show'   , ['GET']    , '/user/{id}'      , 'UserController@show'),
            $r2 = new Route('user.edit'   , ['GET']    , '/user/{id}/edit' , 'UserController@edit'),
        ]);

        $r3 = new Route('user.delete', ['DELETE'], '/user/{id}/', 'UserController@delete');

        $router = new Router($routes);
        $router->getRouteCollection()->addRoute($r3);

        $this->assertEquals([
            'GET' => [
                'user.show' => $r1,
                'user.edit' => $r2
            ],
            'DELETE' => [
                'user.delete' => $r3
            ]
        ], $router->getRouteCollection()->getRoutes());

        $router->getRouteCollection()->deleteRoute($r3);

        $this->assertEquals([
            'GET' => [
                'user.show' => $r1,
                'user.edit' => $r2
            ]
        ], $router->getRouteCollection()->getRoutes());

    }
}