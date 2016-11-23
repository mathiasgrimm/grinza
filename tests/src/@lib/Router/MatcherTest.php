<?php

use Grinza\Router\Matcher;
use Grinza\Router\Route;
use Grinza\Router\RouteCollection;

class MatcherTest extends TestCase
{
    private function getMatcher()
    {
        return new Matcher();
    }

    /**
     * @test
     */
    public function it_matches_exact_route()
    {
        $routeCollection = new RouteCollection([
            $r1 = new Route('user.index', 'GET', '/user'      , 'UserController@index'),
            $r2 = new Route('user.show' , 'GET', '/user/{id}' , 'UserController@show'),
        ]);

        $matcher = $this->getMatcher();

        $match = $matcher->match($routeCollection, '/user', 'GET');

        $this->assertSame($r1, $match->getRoute());
        $this->assertNull($match->getParams());
    }

    /**
     * @test
     */
    public function it_matches_pattern()
    {
        $routeCollection = new RouteCollection([
            $r1 = new Route('user.index', 'GET', '/user'               , 'UserController@index'),
            $r2 = new Route('user.show' , 'GET', '/user/{id}/{locale}' , 'UserController@show'),
        ]);

        $matcher = $this->getMatcher();

        $match = $matcher->match($routeCollection, '/user/1/en', 'GET');

        $this->assertSame($r2, $match->getRoute());
        $this->assertEquals([
            'id'     => '1',
            'locale' => 'en'
        ], $match->getParams());
    }

    /**
     * @test
     */
    public function it_returns_null_when_no_match_is_found()
    {
        $routeCollection = new RouteCollection([
            $r1 = new Route('user.index', 'GET', '/user'               , 'UserController@index'),
            $r2 = new Route('user.show' , 'GET', '/user/{id}/{locale}' , 'UserController@show'),
        ]);

        $matcher = $this->getMatcher();

        $match = $matcher->match($routeCollection, '/user/1/en/1', 'GET');
        $this->assertNull($match);
    }
}