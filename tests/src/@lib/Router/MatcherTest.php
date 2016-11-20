<?php

use Grinza\Router\Matcher;
use Grinza\Router\Route;

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
        $routeCollection = [
            $r1 = new Route('user.index', 'GET', '/user'      , 'UserController', 'index'),
            $r2 = new Route('user.show' , 'GET', '/user/{id}' , 'UserController', 'show'),
        ];

        $matcher = $this->getMatcher();

        $match = $matcher->match($routeCollection, '/user', 'GET');

        $this->assertSame($r1, $match->getRoute());
    }
}