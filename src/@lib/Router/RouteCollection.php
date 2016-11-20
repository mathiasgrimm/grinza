<?php namespace Grinza\Router;

class RouteCollection
{
    private $routes;

    /**
     * Checks if the route has all required attributes
     *
     * @param Route $route
     * @throws \InvalidArgumentException
     */
    public function validate(Route $route)
    {
        if (!$route->getHttpMethod()) {
            throw new \InvalidArgumentException('Route does not have httpMethod and therefore cant be added');
        }

        if (!$route->getPattern()) {
            throw new \InvalidArgumentException('Route does not have pattern and therefore cant be added');
        }

        if (!$route->getController()) {
            throw new \InvalidArgumentException('Route does not have controller and therefore cant be added');
        }

        if (!$route->getControllerMethod()) {
            throw new \InvalidArgumentException('Route does not have controllerMethod and therefore cant be added');
        }
    }

    public function addRoute(Route $route)
    {
        $this->validate($route);

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

    public function __construct(array $routes = null)
    {
        if ($routes) {
            $this->addRoutes($routes);
        }
    }
}