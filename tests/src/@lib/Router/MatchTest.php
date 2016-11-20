<?php

use Grinza\Router\Route;

class MatchTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_does_not_fail_with_nulls()
    {
        $route = new Grinza\Router\Match();
    }

    /**
     * @test
     */
    public function getters_and_setters_work()
    {
        $match = new Grinza\Router\Match();

        $params = [1,2,3];
        $route  = new Route();

        $match->setParams($params);
        $match->setRoute($route);

        $this->assertEquals($params, $match->getParams());
        $this->assertSame($route, $match->getRoute());
    }

    /**
     * @test
     */
    public function constructor_sets_variables_correctly()
    {
        $params = [1,2,3];
        $route  = new Route();

        $match = new Grinza\Router\Match($params, $route);

        $this->assertEquals($params, $match->getParams());
        $this->assertSame($route, $match->getRoute());
    }

    /**
     * @expectedException TypeError
     * @test
     */
    public function constructor_should_accept_correct_types()
    {
        $match = new Grinza\Router\Match(123, new Route());
        $match = new Grinza\Router\Match([1,2,3], '123');
    }
}