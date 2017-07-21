<?php namespace Grinza\Router;

use Grinza\Http\Request;

class Router
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var Matcher
     */
    private $matcher;

    /**
     * @return RouteCollection
     */
    public function getRouteCollection(): ?RouteCollection
    {
        return $this->routeCollection;
    }

    /**
     * @param RouteCollection $routes
     * @return Router
     */
    public function setRouteCollection(RouteCollection $routes): Router
    {
        $this->routeCollection = $routes;
        return $this;
    }

    /**
     * @return Matcher|null
     */
    public function getMatcher(): ?Matcher
    {
        return $this->matcher;
    }

    /**
     * @param Matcher $matcher
     * @return Router
     */
    public function setMatcher(Matcher $matcher): Router
    {
        $this->matcher = $matcher;
        return $this;
    }

    /**
     * Router constructor.
     * @param RouteCollection $routeCollection
     * @param Matcher $matcher
     */
    public function __construct(RouteCollection $routeCollection = null, Matcher $matcher = null)
    {
        $this->routeCollection  = $routeCollection;
        $this->matcher = $matcher;
    }

    /**
     * @param Request $request
     * @return Match|null
     */
    public function match(Request $request): ?Match
    {
        $server = $request->getServer();
        $urn    = $server['REQUEST_URI'];
        $method = $server['REQUEST_METHOD'];

        $match  = $this->matcher->match($this->routeCollection, $urn, [$method]);

        return $match;
    }
}