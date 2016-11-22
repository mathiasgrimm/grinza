<?php namespace Grinza\Router;

use Grinza\Http\Request;

class Router
{
    private $routes;
    private $matcher;

    public function __construct(RouteCollection $routes, Matcher $matcher)
    {
        $this->routes  = $routes;
        $this->matcher = $matcher;
    }

    /**
     * @param Request $request
     * @return Match|null
     */
    public function match(Request $request)
    {
        $server = $request->getServer();
        $urn    = $server['REQUEST_URI'];
        $method = $server['REQUEST_METHOD'];

        $match  = $this->matcher->match($this->routes, $urn, $method);

        return $match;
    }
}