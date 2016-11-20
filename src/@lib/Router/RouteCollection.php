<?php namespace Grinza\Router;

class RouteCollection
{
    private $routes;

    public function addRoute(Route $route)
    {
        if ($name = $route->getName()) {
            $this->routes[$route->getHttpMethod()][$name] = $route;
        } else {
            $this->routes[$route->getHttpMethod()][] = $route;
        }

        return $this;
    }

    public function addRoutes(array $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function deleteRoute(Route $route)
    {
        if ($name = $route->getName()) {
            unset($this->routes[$route->getHttpMethod()][$route->getName()]);
        } else {
            throw new \InvalidArgumentException('Route does not have name and therefore cant be deleted');
        }

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function __construct()
    {

    }
}